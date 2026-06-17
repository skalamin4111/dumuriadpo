with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. View Student Modal Date of Birth
old_dob = """<div class="col-span-2 font-medium" x-text="viewStudent?.date_of_birth || 'N/A'"></div>"""
new_dob = """<div class="col-span-2 font-medium" x-text="viewStudent?.date_of_birth ? new Date(viewStudent.date_of_birth).toLocaleDateString('en-GB') : 'N/A'"></div>"""
content = content.replace(old_dob, new_dob)

# 2. View Student Modal Admission Date
old_admission = """<div class="col-span-2 font-medium" x-text="viewStudent?.admission_date || 'N/A'"></div>"""
new_admission = """<div class="col-span-2 font-medium" x-text="viewStudent?.admission_date ? new Date(viewStudent.admission_date).toLocaleDateString('en-GB') : 'N/A'"></div>"""
content = content.replace(old_admission, new_admission)

# 3. View Batch Modal Admission Date
old_batch_adm = """<td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.admission_date || '-'"></td>"""
new_batch_adm = """<td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.admission_date ? new Date(s.admission_date).toLocaleDateString('en-GB') : '-'"></td>"""
content = content.replace(old_batch_adm, new_batch_adm)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Dates formatted!")
