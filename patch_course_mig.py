import glob

files = glob.glob('database/migrations/*create_computer_training_courses_table.php')
if files:
    with open(files[0], 'r') as f:
        content = f.read()

    search = """            $table->id();
            $table->timestamps();"""
    replace = """            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('name');
            $table->string('duration')->nullable();
            $table->decimal('fee', 10, 2)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();"""
    
    content = content.replace(search, replace)
    
    with open(files[0], 'w') as f:
        f.write(content)
    print("Migration updated")
else:
    print("Migration not found")
