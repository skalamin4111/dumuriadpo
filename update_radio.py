with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. Update JS default state
search_js = """                            status: 'present', // default
                            daily_rank: '' // default empty"""
replace_js = """                            status: '', // default empty, checker must select
                            daily_rank: '' // default empty"""
content = content.replace(search_js, replace_js)

# 2. Update radio button design
search_radios = """                                                    <td class="px-4 py-3 text-center">
                                                        <label class="inline-flex items-center justify-center cursor-pointer w-full h-full p-2">
                                                            <input type="radio" :name="`attendances[${index}][status]`" value="present" x-model="s.status" class="w-5 h-5 text-green-600 bg-slate-100 border-slate-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <label class="inline-flex items-center justify-center cursor-pointer w-full h-full p-2">
                                                            <input type="radio" :name="`attendances[${index}][status]`" value="absent" x-model="s.status" class="w-5 h-5 text-red-600 bg-slate-100 border-slate-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                                        </label>
                                                    </td>"""

replace_radios = """                                                    <td class="px-4 py-3 text-center">
                                                        <label class="inline-flex items-center justify-center cursor-pointer group">
                                                            <input type="radio" :name="`attendances[${index}][status]`" value="present" x-model="s.status" class="peer sr-only" required>
                                                            <div class="w-7 h-7 rounded-full border-2 border-slate-300 dark:border-slate-600 peer-checked:bg-green-500 peer-checked:border-green-500 group-hover:border-green-400 transition-all flex items-center justify-center shadow-sm">
                                                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity scale-50 peer-checked:scale-100 duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                            </div>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <label class="inline-flex items-center justify-center cursor-pointer group">
                                                            <input type="radio" :name="`attendances[${index}][status]`" value="absent" x-model="s.status" class="peer sr-only" required>
                                                            <div class="w-7 h-7 rounded-full border-2 border-slate-300 dark:border-slate-600 peer-checked:bg-red-500 peer-checked:border-red-500 group-hover:border-red-400 transition-all flex items-center justify-center shadow-sm">
                                                                <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity scale-50 peer-checked:scale-100 duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                            </div>
                                                        </label>
                                                    </td>"""
content = content.replace(search_radios, replace_radios)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Radio buttons updated")
