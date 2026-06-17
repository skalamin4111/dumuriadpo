import re

with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# Replace w-X h-X with size-X or inline styles on the empty states.
# Let's just do a regex for w-(\d+) h-\1 and replace with size-\1 to be safe, but wait!
# If size-\1 is also not compiled, it will break.
# Let's use style="width: {n/4}rem; height: {n/4}rem;" for w-16, w-12, w-8

content = re.sub(r'class="([^"]*)w-16 h-16([^"]*)"', r'class="\1\2" style="width: 4rem; height: 4rem;"', content)
content = re.sub(r'class="([^"]*)w-12 h-12([^"]*)"', r'class="\1\2" style="width: 3rem; height: 3rem;"', content)
content = re.sub(r'class="([^"]*)w-8 h-8([^"]*)"', r'class="\1\2" style="width: 2rem; height: 2rem;"', content)

# There's also some other icons. Wait, in the project the author used `size-4`, `size-5`.
# Let's change `w-` and `h-` to `size-` for standard small icons, as they are very likely compiled.
content = re.sub(r'w-4 h-4', r'size-4', content)
content = re.sub(r'w-5 h-5', r'size-5', content)
content = re.sub(r'w-6 h-6', r'size-6', content)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Icons fixed")
