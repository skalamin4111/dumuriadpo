with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

search = """                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Duration (Optional)</label>
                                            <input class="field" name="duration" x-model="course.duration" placeholder="e.g. 6 Months">
                                        </div>"""

replace = """                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Duration (Optional)</label>
                                            <select class="field" name="duration" x-model="course.duration">
                                                <option value="">Select Duration</option>
                                                <option value="1 Month">1 Month</option>
                                                <option value="2 Months">2 Months</option>
                                                <option value="3 Months">3 Months</option>
                                                <option value="4 Months">4 Months</option>
                                                <option value="5 Months">5 Months</option>
                                                <option value="6 Months">6 Months</option>
                                            </select>
                                        </div>"""

if search in content:
    content = content.replace(search, replace)
    with open('resources/views/services/computer-training.blade.php', 'w') as f:
        f.write(content)
    print("Duration dropdown updated successfully.")
else:
    print("Could not find the duration input block.")
