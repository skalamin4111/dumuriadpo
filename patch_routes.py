with open('routes/web.php', 'r') as f:
    content = f.read()

batch_routes = """    Route::post('/services/computer-training/batches', [ComputerTrainingController::class, 'storeBatch'])->name('computer-training.batches.store');
    Route::put('/services/computer-training/batches/{batch}', [ComputerTrainingController::class, 'updateBatch'])->name('computer-training.batches.update');
    Route::delete('/services/computer-training/batches/{batch}', [ComputerTrainingController::class, 'destroyBatch'])->name('computer-training.batches.destroy');"""

course_routes = """    Route::post('/services/computer-training/batches', [ComputerTrainingController::class, 'storeBatch'])->name('computer-training.batches.store');
    Route::put('/services/computer-training/batches/{batch}', [ComputerTrainingController::class, 'updateBatch'])->name('computer-training.batches.update');
    Route::delete('/services/computer-training/batches/{batch}', [ComputerTrainingController::class, 'destroyBatch'])->name('computer-training.batches.destroy');

    Route::post('/services/computer-training/courses', [ComputerTrainingController::class, 'storeCourse'])->name('computer-training.courses.store');
    Route::put('/services/computer-training/courses/{course}', [ComputerTrainingController::class, 'updateCourse'])->name('computer-training.courses.update');
    Route::delete('/services/computer-training/courses/{course}', [ComputerTrainingController::class, 'destroyCourse'])->name('computer-training.courses.destroy');"""

if course_routes not in content:
    content = content.replace(batch_routes, course_routes)
    with open('routes/web.php', 'w') as f:
        f.write(content)
    print("Routes updated")
else:
    print("Routes already updated")
