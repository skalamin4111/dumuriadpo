import re

with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. Update x-data
content = content.replace("showStudentModal: false", "student: null")

# 2. Update x-show and @click.self
content = content.replace("x-show=\"showStudentModal\"", "x-show=\"student !== null\"")
content = content.replace("@click.self=\"showStudentModal = false\"", "@click.self=\"student = null\"")
content = content.replace("@click=\"showStudentModal = false\"", "@click=\"student = null\"")

# 3. Form action and method
form_start = """<form method="POST" action="{{ route('computer-training.students.store') }}" class="p-6 md:p-8">
                            @csrf"""
form_replacement = """<form method="POST" :action="student && student.id ? '{{ url('/services/computer-training/students') }}/' + student.id : '{{ route('computer-training.students.store') }}'" class="p-6 md:p-8">
                            @csrf
                            <input type="hidden" name="_method" :value="student && student.id ? 'PUT' : 'POST'">"""
content = content.replace(form_start, form_replacement)

# 4. Form title
content = content.replace("<span>কম্পিউটার প্রশিক্ষণ কোর্সে ভর্তির আবেদন ফরম (Add New Student)</span>", "<span x-text=\"student && student.id ? 'কম্পিউটার প্রশিক্ষণ কোর্সে ভর্তির তথ্য আপডেট (Edit Student)' : 'কম্পিউটার প্রশিক্ষণ কোর্সে ভর্তির আবেদন ফরম (Add New Student)'\"></span>")
content = content.replace("<button class=\"btn btn-primary w-full py-3 mt-4 text-base font-semibold\">Save student record</button>", "<button class=\"btn btn-primary w-full py-3 mt-4 text-base font-semibold\" x-text=\"student && student.id ? 'Update student record' : 'Save student record'\"></button>")

# 5. Inputs (replace value="{{ old('field') }}" with x-model="student.field")
fields = ['name', 'name_bn', 'father_name', 'mother_name', 'date_of_birth', 'nid_or_birth_reg', 'phone', 'email', 'guardian_name', 'guardian_phone', 'duration', 'student_id', 'notes']
for field in fields:
    # use plain string replace instead of regex for simplicity where possible, but regex is needed for old('...', ...)
    # Let's just do a blanket regex, carefully escaped
    content = re.sub(r'value="\{\{\s*old\(\'' + field + r'\'(?:,\s*[^)]+)?\)\s*\}\}"', f'x-model="student.{field}"', content)

# 6. Textarea
content = re.sub(r'>\{\{\s*old\(\'address\'\)\s*\}\}</textarea>', r' x-model="student.address"></textarea>', content)

# 7. Selects and specialized defaults
content = re.sub(r'value="\{\{\s*old\(\'nationality\',\s*\'Bangladeshi\'\)\s*\}\}"', r'x-model="student.nationality"', content)
content = re.sub(r'value="\{\{\s*old\(\'admission_date\',\s*now\(\)->toDateString\(\)\)\s*\}\}"', r'x-model="student.admission_date"', content)

for sel in ['gender', 'marital_status', 'religion', 'course', 'status']:
    content = re.sub(r'<select class="field" name="' + sel + r'"([^>]*)>', r'<select class="field" name="' + sel + r'" x-model="student.' + sel + r'"\1>', content)

content = re.sub(r'\s*@selected\([^)]+\)', '', content)

# 8. Educational Qualifications
fields_ed = ['exam_name', 'group', 'institute', 'passing_year', 'board', 'grade']
for f in fields_ed:
    # Look for value="{{ old('educational_qualifications.'.$i.'.field') }}"
    search_str = r'value="\{\{\s*old\(\'educational_qualifications\.\'\.\$i\.\'\.' + f + r'\'\)\s*\}\}"'
    replace_str = r'x-model="student.educational_qualifications[{{$i}}].' + f + r'"'
    content = re.sub(search_str, replace_str, content)

# 9. "Add New Student" button click
add_btn_old = """@click="showStudentModal = true\""""
add_btn_new = """@click="student = { id: null, name: '', name_bn: '', father_name: '', mother_name: '', date_of_birth: '', nid_or_birth_reg: '', nationality: 'Bangladeshi', gender: '', marital_status: '', religion: '', educational_qualifications: [{}, {}], course: '', duration: '', admission_date: '{{ now()->toDateString() }}', student_id: '', guardian_name: '', guardian_phone: '', status: 'admitted', notes: '', address: '', phone: '', email: '' }\""""
content = content.replace(add_btn_old, add_btn_new)

# 10. Edit and Delete buttons on table
table_row_old = """<tr class="table-row"><td class="px-4 py-3 font-medium">{{ $student->name }}<span class="block text-xs text-slate-500">{{ $student->student_id }}</span></td><td class="px-4 py-3">{{ $student->course }}</td><td class="px-4 py-3">{{ $student->phone ?? 'N/A' }}</td><td class="px-4 py-3">{{ ucfirst($student->status) }}</td></tr>"""
table_row_new = """<tr class="table-row">
                            <td class="px-4 py-3 font-medium">{{ $student->name }}<span class="block text-xs text-slate-500">{{ $student->student_id }}</span></td>
                            <td class="px-4 py-3">{{ $student->course }}</td>
                            <td class="px-4 py-3">{{ $student->phone ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ ucfirst($student->status) }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" @click="student = Object.assign({}, {{ Js::from($student) }}, { educational_qualifications: ({{ Js::from($student) }}.educational_qualifications || []).concat([{}, {}]).slice(0, 2) })" class="text-teal-600 hover:text-teal-800 transition"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                    <form method="POST" action="{{ route('computer-training.students.destroy', $student) }}" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 transition"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>"""

content = content.replace(table_row_old, table_row_new)
content = content.replace('<thead class="table-head"><tr><th class="px-4 py-3">Student</th><th class="px-4 py-3">Course</th><th class="px-4 py-3">Phone</th><th class="px-4 py-3">Status</th></tr></thead>', '<thead class="table-head"><tr><th class="px-4 py-3">Student</th><th class="px-4 py-3">Course</th><th class="px-4 py-3">Phone</th><th class="px-4 py-3">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead>')

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Patched!")
