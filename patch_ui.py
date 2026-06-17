with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. Add getTakenSeats to x-data
old_xdata = """<div x-data="{ tab: '{{ session('tab', old('tab', request('tab', 'students'))) }}', marketingLead: null, student: null, viewStudent: null }" class="space-y-5">"""
new_xdata = """<div x-data="{ 
    tab: '{{ session('tab', old('tab', request('tab', 'students'))) }}', 
    marketingLead: null, 
    student: null, 
    viewStudent: null,
    getTakenSeats() {
        if (!this.student || !this.student.batch_id) return [];
        let batch = {{ Js::from($batches) }}.find(b => b.id == this.student.batch_id);
        if (!batch || !batch.students) return [];
        return batch.students.filter(s => s.id !== this.student.id).map(s => s.seat_number).filter(n => n !== null);
    }
}" class="space-y-5">"""
content = content.replace(old_xdata, new_xdata)

# 2. Add seat_number to student object inside "Add New Student" button
old_add_btn = "batch_id: '' }"
new_add_btn = "batch_id: '', seat_number: '' }"
content = content.replace(old_add_btn, new_add_btn)

# 3. Add Seat dropdown in Student Form
batch_dropdown = """                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">ব্যাচ / Batch</label>
                                        <select class="field" name="batch_id" x-model="student.batch_id">
                                            <option value="">Select Batch</option>
                                            @foreach ($batches as $b)
                                                <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->type }}) - {{ $b->students_count }}/{{ $b->capacity }}</option>
                                            @endforeach
                                        </select>
                                    </div>"""
seat_dropdown = """                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">ব্যাচ / Batch</label>
                                        <select class="field" name="batch_id" x-model="student.batch_id" @change="student.seat_number = ''">
                                            <option value="">Select Batch</option>
                                            @foreach ($batches as $b)
                                                <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->type }}) - {{ $b->students_count }}/{{ $b->capacity }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-2" x-show="student.batch_id">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">আসন নং / Seat No</label>
                                        <select class="field" name="seat_number" x-model="student.seat_number" :required="student.batch_id ? true : false">
                                            <option value="">Select Seat</option>
                                            <template x-for="seat in 15" :key="seat">
                                                <option :value="seat" :disabled="getTakenSeats().includes(seat)" x-text="`Seat ${seat} ${getTakenSeats().includes(seat) ? '(Taken)' : '(Available)'}`"></option>
                                            </template>
                                        </select>
                                    </div>"""
content = content.replace(batch_dropdown, seat_dropdown)

# 4. Add Seat Number to View Student Details
view_student_batch = """<div class="text-slate-500">Batch:</div><div class="col-span-2 font-medium" x-text="viewStudent?.batch?.name || 'Unassigned'"></div>"""
view_student_seat = """<div class="text-slate-500">Batch:</div><div class="col-span-2 font-medium" x-text="viewStudent?.batch?.name || 'Unassigned'"></div>
                                        <div class="text-slate-500">Seat Number:</div><div class="col-span-2 font-medium" x-text="viewStudent?.seat_number || 'N/A'"></div>"""
content = content.replace(view_student_batch, view_student_seat)

# 5. Add Seat Number to Student Table List
student_table_batch = """@if($student->batch) &bull; <span class="font-medium text-teal-600">{{ $student->batch->name }}</span> @endif"""
student_table_seat = """@if($student->batch) &bull; <span class="font-medium text-teal-600">{{ $student->batch->name }} (Seat: {{ $student->seat_number ?? 'N/A' }})</span> @endif"""
content = content.replace(student_table_batch, student_table_seat)

# 6. Add Seat to Batch View Modal Header
batch_modal_th = """<th class="px-4 py-3 font-medium">Course</th>
                                                <th class="px-4 py-3 font-medium">Admission Date</th>"""
new_batch_modal_th = """<th class="px-4 py-3 font-medium">Course</th>
                                                <th class="px-4 py-3 font-medium">Seat</th>
                                                <th class="px-4 py-3 font-medium">Admission Date</th>"""
content = content.replace(batch_modal_th, new_batch_modal_th)

# 7. Add Seat to Batch View Modal Row
batch_modal_td = """<td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.course"></td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.admission_date ? new Date(s.admission_date).toLocaleDateString('en-GB') : '-'"></td>"""
new_batch_modal_td = """<td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.course"></td>
                                                        <td class="px-4 py-3 font-semibold text-teal-600 dark:text-teal-400" x-text="s.seat_number || 'N/A'"></td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.admission_date ? new Date(s.admission_date).toLocaleDateString('en-GB') : '-'"></td>"""
content = content.replace(batch_modal_td, new_batch_modal_td)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("UI patched!")
