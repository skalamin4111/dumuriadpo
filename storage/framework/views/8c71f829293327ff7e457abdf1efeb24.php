<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Computer Training']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Computer Training']); ?>
    <div x-data="{ 
    tab: '<?php echo e(session('tab', old('tab', request('tab', 'students')))); ?>', 
    marketingLead: null, 
    student: null, 
    viewStudent: null,
    getTakenSeats() {
        if (!this.student || !this.student.batch_id) return [];
        let batch = <?php echo e(Js::from($batches)); ?>.find(b => b.id == this.student.batch_id);
        if (!batch || !batch.students) return [];
        return batch.students.filter(s => s.id !== this.student.id).map(s => s.seat_number).filter(n => n !== null);
    }
}" class="space-y-5">
        <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <div class="surface p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Active students</p>
                <p class="mt-2 text-2xl font-semibold"><?php echo e($stats['active_students']); ?></p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Upcoming classes</p>
                <p class="mt-2 text-2xl font-semibold"><?php echo e($stats['upcoming_classes']); ?></p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Open leads</p>
                <p class="mt-2 text-2xl font-semibold"><?php echo e($stats['open_leads']); ?></p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Fee receivable</p>
                <p class="mt-2 text-2xl font-semibold"><?php echo e(number_format($stats['due_fees'], 2)); ?></p>
            </div>
        </section>

        <?php if($errors->any()): ?>
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-900 dark:bg-rose-950 dark:text-rose-200">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <section class="surface p-2">
            <div class="flex gap-1 overflow-x-auto">
                <?php $__currentLoopData = [
                    'students' => 'Students',
                    'batches' => 'Batches',
                    'attendance' => 'Attendance',
                    'classes' => 'Class Schedule',
                    'exams' => 'Class Exam',
                    'fees' => 'Fee Management',
                    'marketing' => 'Marketing',
                    'reminders' => 'To-do / Reminder',
                    'notices' => 'Notice',
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button type="button" x-on:click="tab = '<?php echo e($key); ?>'" class="shrink-0 rounded-md px-3 py-2 text-sm font-medium transition" x-bind:class="tab === '<?php echo e($key); ?>' ? 'bg-teal-600 text-white' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'"><?php echo e($label); ?></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        <section x-show="tab === 'students'" class="grid gap-5">
            <template x-teleport="body">
                <div x-show="student !== null" 
                     class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                     style="display:none"
                     x-transition.opacity>
                    <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="student = null">
                        <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative" 
                             x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0" 
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                             x-transition:leave="transition ease-in duration-200" 
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                             x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0">
                            <form method="POST" :action="student && student.id ? '<?php echo e(url('/services/computer-training/students')); ?>/' + student.id : '<?php echo e(route('computer-training.students.store')); ?>'" class="p-6 md:p-8">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="_method" :value="student && student.id ? 'PUT' : 'POST'">
                            <h2 class="mb-6 font-semibold text-xl flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                <span x-text="student && student.id ? 'কম্পিউটার প্রশিক্ষণ কোর্সে ভর্তির তথ্য আপডেট (Edit Student)' : 'কম্পিউটার প্রশিক্ষণ কোর্সে ভর্তির আবেদন ফরম (Add New Student)'"></span>
                                <button type="button" @click="student = null" class="text-slate-400 hover:text-slate-600 transition">
                                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </h2>
                            <div class="space-y-6">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">আবেদনকারীর নাম (ইংরেজীতে) / Name (English)</label>
                                        <input class="field" name="name" x-model="student.name" placeholder="Enter full name in English" required>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">আবেদনকারীর নাম (বাংলায়) / Name (Bengali)</label>
                                        <input class="field" name="name_bn" x-model="student.name_bn" placeholder="বাংলায় নাম লিখুন">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">পিতার নাম / Father's Name</label>
                                        <input class="field" name="father_name" x-model="student.father_name" placeholder="Father's name">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">মাতার নাম / Mother's Name</label>
                                        <input class="field" name="mother_name" x-model="student.mother_name" placeholder="Mother's name">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">জন্ম তারিখ / Date of Birth</label>
                                        <input class="field" type="date" name="date_of_birth" x-model="student.date_of_birth">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">জাতীয় পরিচয় পত্র/জন্ম নিবন্ধন / NID/Birth Reg.</label>
                                        <input class="field" name="nid_or_birth_reg" x-model="student.nid_or_birth_reg" placeholder="NID or Birth Reg No">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">মোবাইল নম্বর / Mobile No</label>
                                        <input class="field" name="phone" x-model="student.phone" placeholder="Phone">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">ই-মেইল / Email</label>
                                        <input class="field" type="email" name="email" x-model="student.email" placeholder="Email (if any)">
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">বর্তমান ঠিকানা / Present Address</label>
                                        <textarea class="field" name="address" placeholder="Present Address" rows="2" x-model="student.address"></textarea>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">জাতীয়তা / Nationality</label>
                                        <input class="field" name="nationality" x-model="student.nationality">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">জেন্ডার / Gender</label>
                                        <select class="field" name="gender" x-model="student.gender">
                                            <option value="">Select</option>
                                            <option value="Male" == 'Male')>পুরুষ / Male</option>
                                            <option value="Female" == 'Female')>মহিলা / Female</option>
                                            <option value="Other" == 'Other')>অন্যান্য / Other</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">বৈবাহিক অবস্থা / Marital Status</label>
                                        <select class="field" name="marital_status" x-model="student.marital_status">
                                            <option value="">Select</option>
                                            <option value="Married" == 'Married')>বিবাহিত / Married</option>
                                            <option value="Unmarried" == 'Unmarried')>অবিবাহিত / Unmarried</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">ধর্ম / Religion</label>
                                        <select class="field" name="religion" x-model="student.religion">
                                            <option value="">Select</option>
                                            <option value="Islam" == 'Islam')>ইসলাম / Islam</option>
                                            <option value="Hindu" == 'Hindu')>হিন্দু / Hindu</option>
                                            <option value="Christian" == 'Christian')>খ্রিস্টান / Christian</option>
                                            <option value="Other" == 'Other')>অন্যান্য / Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">শিক্ষাগত যোগ্যতা / Educational Qualifications</label>
                                    <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-x-auto">
                                        <table class="w-full text-left text-sm whitespace-nowrap">
                                            <thead class="bg-slate-50 dark:bg-slate-800/50">
                                                <tr>
                                                    <th class="px-3 py-2 font-medium">পরীক্ষার নাম (Exam)</th>
                                                    <th class="px-3 py-2 font-medium">বিভাগ (Group)</th>
                                                    <th class="px-3 py-2 font-medium">শিক্ষা প্রতিষ্ঠান (Institute)</th>
                                                    <th class="px-3 py-2 font-medium">পাসের সন (Year)</th>
                                                    <th class="px-3 py-2 font-medium">বোর্ড/বিশ্ববিদ্যালয় (Board)</th>
                                                    <th class="px-3 py-2 font-medium">গ্রেড/শ্রেণী (Grade)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                                <?php for($i = 0; $i < 2; $i++): ?>
                                                <tr>
                                                    <td class="p-2 border-r border-slate-200 dark:border-slate-800"><input class="field py-1.5 px-2 text-sm bg-transparent border-none shadow-none" name="educational_qualifications[<?php echo e($i); ?>][exam_name]" x-model="student.educational_qualifications[<?php echo e($i); ?>].exam_name" placeholder="Exam"></td>
                                                    <td class="p-2 border-r border-slate-200 dark:border-slate-800"><input class="field py-1.5 px-2 text-sm bg-transparent border-none shadow-none" name="educational_qualifications[<?php echo e($i); ?>][group]" x-model="student.educational_qualifications[<?php echo e($i); ?>].group" placeholder="Group"></td>
                                                    <td class="p-2 border-r border-slate-200 dark:border-slate-800"><input class="field py-1.5 px-2 text-sm bg-transparent border-none shadow-none" name="educational_qualifications[<?php echo e($i); ?>][institute]" x-model="student.educational_qualifications[<?php echo e($i); ?>].institute" placeholder="Institute"></td>
                                                    <td class="p-2 border-r border-slate-200 dark:border-slate-800"><input class="field py-1.5 px-2 text-sm bg-transparent border-none shadow-none" name="educational_qualifications[<?php echo e($i); ?>][passing_year]" x-model="student.educational_qualifications[<?php echo e($i); ?>].passing_year" placeholder="Year"></td>
                                                    <td class="p-2 border-r border-slate-200 dark:border-slate-800"><input class="field py-1.5 px-2 text-sm bg-transparent border-none shadow-none" name="educational_qualifications[<?php echo e($i); ?>][board]" x-model="student.educational_qualifications[<?php echo e($i); ?>].board" placeholder="Board"></td>
                                                    <td class="p-2"><input class="field py-1.5 px-2 text-sm bg-transparent border-none shadow-none" name="educational_qualifications[<?php echo e($i); ?>][grade]" x-model="student.educational_qualifications[<?php echo e($i); ?>].grade" placeholder="Grade"></td>
                                                </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">ব্যাচ / Batch</label>
                                        <select class="field" name="batch_id" x-model="student.batch_id" @change="student.seat_number = ''">
                                            <option value="">Select Batch</option>
                                            <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($b->id); ?>"><?php echo e($b->name); ?> (<?php echo e($b->type); ?>) - <?php echo e($b->students_count); ?>/<?php echo e($b->capacity); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">প্রশিক্ষণ কোর্সের নাম / Course Name</label>
                                        <select class="field" name="course" x-model="student.course" required>
                                            <option value="">Select Course</option>
                                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($course); ?>" === $course)><?php echo e($course); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">প্রশিক্ষণকাল / Duration</label>
                                        <input class="field" name="duration" x-model="student.duration" placeholder="e.g., 6 Months">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">ভর্তির তারিখ / Admission Date</label>
                                        <input class="field" name="admission_date" type="date" x-model="student.admission_date">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">সেশন / Session</label>
                                        <select class="field" name="session" x-model="student.session">
                                            <option value="">Select Session</option>
                                            <template x-if="student.admission_date">
                                                <option :value="`${new Date(student.admission_date).getFullYear()}-1`" x-text="`${new Date(student.admission_date).getFullYear()}-1`"></option>
                                            </template>
                                            <template x-if="student.admission_date">
                                                <option :value="`${new Date(student.admission_date).getFullYear()}-2`" x-text="`${new Date(student.admission_date).getFullYear()}-2`"></option>
                                            </template>
                                            <template x-if="student.session && (!student.admission_date || ![`${new Date(student.admission_date).getFullYear()}-1`, `${new Date(student.admission_date).getFullYear()}-2`].includes(student.session))">
                                                <option :value="student.session" x-text="student.session"></option>
                                            </template>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">ক্রমিক নং / Serial No (Student ID)</label>
                                        <input class="field" name="student_id" x-model="student.student_id" placeholder="Optional custom ID" x-effect="if (!student.id && student.session) { student.student_id = student.session + (student.seat_number ? '-' + String(student.seat_number).padStart(2, '0') : '') }">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">অভিভাবকের নাম / Guardian's Name</label>
                                        <input class="field" name="guardian_name" x-model="student.guardian_name" placeholder="Guardian's name">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">অভিভাবকের মোবাইল / Guardian Mobile</label>
                                        <input class="field" name="guardian_phone" x-model="student.guardian_phone" placeholder="Guardian's mobile">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-200 dark:border-slate-800 mt-6">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Office Status</label>
                                        <select class="field" name="status" x-model="student.status">
                                            <?php $__currentLoopData = ['lead', 'admitted', 'active', 'completed', 'dropped']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($status); ?>" === $status)><?php echo e(ucfirst($status)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Office Notes</label>
                                        <input class="field" name="notes" x-model="student.notes" placeholder="Internal notes">
                                    </div>
                                </div>
                                
                                <button class="btn btn-primary w-full py-3 mt-4 text-base font-semibold" x-text="student && student.id ? 'Update student record' : 'Save student record'"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>

            <div class="surface overflow-hidden flex flex-col h-full">
                
            <!-- View Student Details Modal -->
            <template x-teleport="body">
                <div x-show="viewStudent !== null" 
                     class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                     style="display:none"
                     x-transition.opacity>
                    <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="viewStudent = null">
                        <div class="w-full max-w-3xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative p-6 md:p-8"
                             x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                             x-transition:leave="transition ease-in duration-200" 
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                             x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                            
                            <h2 class="mb-6 font-semibold text-xl flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                <span>Student Details: <span x-text="viewStudent?.name" class="text-teal-600"></span></span>
                                <button type="button" @click="viewStudent = null" class="text-slate-400 hover:text-slate-600 transition">
                                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-if="viewStudent">
                                
                                <div class="space-y-4">
                                    <h3 class="font-medium text-lg text-slate-800 dark:text-slate-200 border-b pb-2">Basic Info</h3>
                                    <div class="grid grid-cols-3 gap-2 text-sm">
                                        <div class="text-slate-500">Student ID:</div><div class="col-span-2 font-medium" x-text="viewStudent?.student_id || 'N/A'"></div>
                                        <div class="text-slate-500">Name:</div><div class="col-span-2 font-medium" x-text="viewStudent?.name"></div>
                                        <div class="text-slate-500">Name (BN):</div><div class="col-span-2 font-medium" x-text="viewStudent?.name_bn || 'N/A'"></div>
                                        <div class="text-slate-500">Father's Name:</div><div class="col-span-2 font-medium" x-text="viewStudent?.father_name || 'N/A'"></div>
                                        <div class="text-slate-500">Mother's Name:</div><div class="col-span-2 font-medium" x-text="viewStudent?.mother_name || 'N/A'"></div>
                                        <div class="text-slate-500">Date of Birth:</div><div class="col-span-2 font-medium" x-text="viewStudent?.date_of_birth ? new Date(viewStudent.date_of_birth).toLocaleDateString('en-GB') : 'N/A'"></div>
                                        <div class="text-slate-500">Gender:</div><div class="col-span-2 font-medium" x-text="viewStudent?.gender || 'N/A'"></div>
                                        <div class="text-slate-500">Religion:</div><div class="col-span-2 font-medium" x-text="viewStudent?.religion || 'N/A'"></div>
                                        <div class="text-slate-500">Marital Status:</div><div class="col-span-2 font-medium" x-text="viewStudent?.marital_status || 'N/A'"></div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <h3 class="font-medium text-lg text-slate-800 dark:text-slate-200 border-b pb-2">Contact & Course</h3>
                                    <div class="grid grid-cols-3 gap-2 text-sm">
                                        <div class="text-slate-500">Phone:</div><div class="col-span-2 font-medium" x-text="viewStudent?.phone || 'N/A'"></div>
                                        <div class="text-slate-500">Email:</div><div class="col-span-2 font-medium" x-text="viewStudent?.email || 'N/A'"></div>
                                        <div class="text-slate-500">Guardian Name:</div><div class="col-span-2 font-medium" x-text="viewStudent?.guardian_name || 'N/A'"></div>
                                        <div class="text-slate-500">Guardian Phone:</div><div class="col-span-2 font-medium" x-text="viewStudent?.guardian_phone || 'N/A'"></div>
                                        <div class="text-slate-500">Address:</div><div class="col-span-2 font-medium" x-text="viewStudent?.address || 'N/A'"></div>
                                        <div class="col-span-3 my-2 border-t border-slate-100 dark:border-slate-800"></div>
                                        <div class="text-slate-500">Course:</div><div class="col-span-2 font-medium" x-text="viewStudent?.course || 'N/A'"></div>
                                        <div class="text-slate-500">Batch:</div><div class="col-span-2 font-medium" x-text="viewStudent?.batch?.name || 'Unassigned'"></div>
                                        <div class="text-slate-500">Seat Number:</div><div class="col-span-2 font-medium" x-text="viewStudent?.seat_number || 'N/A'"></div>
                                        <div class="text-slate-500">Duration:</div><div class="col-span-2 font-medium" x-text="viewStudent?.duration || 'N/A'"></div>
                                        <div class="text-slate-500">Session:</div><div class="col-span-2 font-medium" x-text="viewStudent?.session || 'N/A'"></div>
                                        <div class="text-slate-500">Admission Date:</div><div class="col-span-2 font-medium" x-text="viewStudent?.admission_date ? new Date(viewStudent.admission_date).toLocaleDateString('en-GB') : 'N/A'"></div>
                                        <div class="text-slate-500">Status:</div>
                                        <div class="col-span-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800" x-text="viewStudent?.status ? viewStudent.status.charAt(0).toUpperCase() + viewStudent.status.slice(1) : 'N/A'"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-span-1 md:col-span-2 space-y-4" x-show="viewStudent?.educational_qualifications && viewStudent.educational_qualifications.length > 0">
                                    <h3 class="font-medium text-lg text-slate-800 dark:text-slate-200 border-b pb-2">Educational Qualifications</h3>
                                    <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
                                        <table class="w-full text-left text-sm whitespace-nowrap">
                                            <thead class="bg-slate-50 dark:bg-slate-800/50">
                                                <tr>
                                                    <th class="px-3 py-2 font-medium">Exam Name</th>
                                                    <th class="px-3 py-2 font-medium">Group</th>
                                                    <th class="px-3 py-2 font-medium">Institute</th>
                                                    <th class="px-3 py-2 font-medium">Passing Year</th>
                                                    <th class="px-3 py-2 font-medium">Board</th>
                                                    <th class="px-3 py-2 font-medium">Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                                <template x-for="(eq, index) in viewStudent?.educational_qualifications" :key="index">
                                                    <tr x-show="eq.exam_name">
                                                        <td class="px-3 py-2" x-text="eq.exam_name"></td>
                                                        <td class="px-3 py-2" x-text="eq.group"></td>
                                                        <td class="px-3 py-2" x-text="eq.institute"></td>
                                                        <td class="px-3 py-2" x-text="eq.passing_year"></td>
                                                        <td class="px-3 py-2" x-text="eq.board"></td>
                                                        <td class="px-3 py-2" x-text="eq.grade"></td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="col-span-1 md:col-span-2 space-y-2" x-show="viewStudent?.notes">
                                    <h3 class="font-medium text-lg text-slate-800 dark:text-slate-200 border-b pb-2">Notes</h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg whitespace-pre-wrap" x-text="viewStudent?.notes"></p>
                                </div>

                            </div>
                            
                            <div class="mt-8 flex justify-end">
                                <button type="button" @click="viewStudent = null" class="btn btn-secondary">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

<div class="flex flex-col gap-4 sm:flex-row sm:items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-200">Student List</h3>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" @click="student = { id: null, name: '', name_bn: '', father_name: '', mother_name: '', date_of_birth: '', nid_or_birth_reg: '', nationality: 'Bangladeshi', gender: '', marital_status: '', religion: '', educational_qualifications: [{}, {}], course: '', duration: '', session: '', admission_date: '<?php echo e(now()->toDateString()); ?>', student_id: '', guardian_name: '', guardian_phone: '', status: 'admitted', notes: '', address: '', phone: '', email: '', batch_id: '', seat_number: '' }" class="btn btn-primary shrink-0">Add New Student</button>
                        <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex items-center gap-2">
                            <input type="hidden" name="tab" value="students">
                            <select name="per_page" onchange="this.form.submit()" class="field text-sm py-1.5 pl-3 pr-8 w-auto">
                                <option value="10" <?php if(request('per_page') == 10): echo 'selected'; endif; ?>>10 per page</option>
                                <option value="25" <?php if(request('per_page') == 25): echo 'selected'; endif; ?>>25 per page</option>
                                <option value="50" <?php if(request('per_page') == 50): echo 'selected'; endif; ?>>50 per page</option>
                                <option value="100" <?php if(request('per_page') == 100): echo 'selected'; endif; ?>>100 per page</option>
                            </select>
                        </form>
                    </div>
                </div>
                <table class="w-full text-left text-sm">
                    <thead class="table-head"><tr><th class="px-4 py-3">Student</th><th class="px-4 py-3">Course</th><th class="px-4 py-3">Phone</th><th class="px-4 py-3">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="table-row cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50" @click="viewStudent = <?php echo e(Js::from($student)); ?>">
                            <td class="px-4 py-3 font-medium">
                                <?php echo e($student->name); ?>

                                <span class="block text-xs text-slate-500">
                                    <?php echo e($student->student_id); ?> 
                                    <?php if($student->batch): ?> &bull; <span class="font-medium text-teal-600"><?php echo e($student->batch->name); ?> (Seat: <?php echo e($student->seat_number ?? 'N/A'); ?>)</span> <?php endif; ?>
                                </span>
                            </td>
                            <td class="px-4 py-3"><?php echo e($student->course); ?></td>
                            <td class="px-4 py-3"><?php echo e($student->phone ?? 'N/A'); ?></td>
                            <td class="px-4 py-3"><?php echo e(ucfirst($student->status)); ?></td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" @click.stop="viewStudent = <?php echo e(Js::from($student)); ?>" class="text-indigo-600 hover:text-indigo-800 transition" title="View Details"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></button>
                                    <button type="button" @click.stop="student = Object.assign({}, <?php echo e(Js::from($student)); ?>, { educational_qualifications: (<?php echo e(Js::from($student)); ?>.educational_qualifications || []).concat([{}, {}]).slice(0, 2) })" class="text-teal-600 hover:text-teal-800 transition"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                    <form method="POST" action="<?php echo e(route('computer-training.students.destroy', $student)); ?>" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" @click.stop class="text-rose-600 hover:text-rose-800 transition"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td class="px-4 py-5 text-center text-slate-500" colspan="4">No students found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4"><?php echo e($students->appends(['tab' => 'students'])->links()); ?></div>
        </section>

        
        <section x-show="tab === 'batches'" class="grid gap-5" x-data="{ activeSubTab: 'batches' }">
            
            <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
                <button type="button" @click="activeSubTab = 'batches'" :class="activeSubTab === 'batches' ? 'bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200'" class="px-4 py-2 rounded-lg text-sm transition whitespace-nowrap">Batch Management</button>
                <button type="button" @click="activeSubTab = 'courses'" :class="activeSubTab === 'courses' ? 'bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200'" class="px-4 py-2 rounded-lg text-sm transition whitespace-nowrap">Course Management</button>
            </div>

            <!-- Batch Management -->
            <div x-show="activeSubTab === 'batches'" x-data="{ batch: null, viewBatch: null }" class="surface overflow-hidden flex flex-col h-full">
                
                <!-- Batch Modal -->
                <template x-teleport="body">
                    <div x-show="batch !== null" 
                         class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                         style="display:none"
                         x-transition.opacity>
                        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="batch = null">
                            <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative">
                                <form method="POST" :action="batch && batch.id ? '<?php echo e(url('/services/computer-training/batches')); ?>/' + batch.id : '<?php echo e(route('computer-training.batches.store')); ?>'" class="p-6">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="_method" :value="batch && batch.id ? 'PUT' : 'POST'">
                                    
                                    <h2 class="mb-4 font-semibold text-lg flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                        <span x-text="batch && batch.id ? 'Edit Batch' : 'Add New Batch'"></span>
                                        <button type="button" @click="batch = null" class="text-slate-400 hover:text-slate-600 transition">
                                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </h2>

                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Batch Name</label>
                                            <input class="field" name="name" x-model="batch.name" placeholder="e.g. S-9, R-9" required>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Type</label>
                                            <select class="field" name="type" x-model="batch.type" required>
                                                <option value="S">S - Batch</option>
                                                <option value="R">R - Batch</option>
                                            </select>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Capacity</label>
                                            <input type="number" class="field" name="capacity" x-model="batch.capacity" required>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                                            <select class="field" name="status" x-model="batch.status" required>
                                                <option value="active">Active</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-primary w-full py-3 mt-6 text-base font-semibold" x-text="batch && batch.id ? 'Update Batch' : 'Save Batch'"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>

                
                <!-- View Batch Details Modal -->
                <template x-teleport="body">
                    <div x-show="viewBatch !== null" 
                         class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                         style="display:none"
                         x-transition.opacity>
                        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="viewBatch = null">
                            <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative p-6 md:p-8"
                                 x-transition:enter="transition ease-out duration-300" 
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                                 x-transition:leave="transition ease-in duration-200" 
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                                
                                <h2 class="mb-6 font-semibold text-xl flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                    <span>Batch Enrolled Students: <span x-text="viewBatch?.name" class="text-teal-600"></span> (<span x-text="viewBatch?.type"></span>)</span>
                                    <button type="button" @click="viewBatch = null" class="text-slate-400 hover:text-slate-600 transition">
                                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </h2>

                                <div class="mb-4 flex items-center justify-between text-sm">
                                    <div class="flex gap-4">
                                        <div class="bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg">
                                            <span class="text-slate-500">Status:</span> 
                                            <span class="font-medium text-slate-800 dark:text-slate-200" x-text="viewBatch?.status === 'active' ? 'Active' : 'Completed'"></span>
                                        </div>
                                        <div class="bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg">
                                            <span class="text-slate-500">Enrolled:</span> 
                                            <span class="font-medium text-slate-800 dark:text-slate-200"><span x-text="viewBatch?.students?.length || 0"></span> / <span x-text="viewBatch?.capacity"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
                                    <table class="w-full text-left text-sm whitespace-nowrap">
                                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                                            <tr>
                                                <th class="px-4 py-3 font-medium">Student Name</th>
                                                <th class="px-4 py-3 font-medium">Phone</th>
                                                <th class="px-4 py-3 font-medium">Course</th>
                                                <th class="px-4 py-3 font-medium">Seat</th>
                                                <th class="px-4 py-3 font-medium">Admission Date</th>
                                                <th class="px-4 py-3 font-medium">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                            <template x-if="viewBatch?.students && viewBatch.students.length > 0">
                                                <template x-for="s in viewBatch.students" :key="s.id">
                                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                                        <td class="px-4 py-3">
                                                            <div class="font-medium text-slate-800 dark:text-slate-200" x-text="s.name"></div>
                                                            <div class="text-xs text-slate-500" x-text="s.student_id"></div>
                                                        </td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.phone || '-'"></td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.course"></td>
                                                        <td class="px-4 py-3 font-semibold text-teal-600 dark:text-teal-400" x-text="s.seat_number || 'N/A'"></td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.admission_date ? new Date(s.admission_date).toLocaleDateString('en-GB') : '-'"></td>
                                                        <td class="px-4 py-3">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800" x-text="s.status.charAt(0).toUpperCase() + s.status.slice(1)"></span>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </template>
                                            <template x-if="!viewBatch?.students || viewBatch.students.length === 0">
                                                <tr>
                                                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No students are enrolled in this batch yet.</td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-6 flex justify-end">
                                    <button type="button" @click="viewBatch = null" class="btn btn-secondary">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

<div class="flex flex-col gap-4 sm:flex-row sm:items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-200">Batch List</h3>
                    <button type="button" @click="batch = { id: null, name: '', type: 'S', capacity: 15, status: 'active' }" class="btn btn-primary shrink-0">Add New Batch</button>
                </div>

                <table class="w-full text-left text-sm">
                    <thead class="table-head">
                        <tr>
                            <th class="px-4 py-3">Batch Name</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Students</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        <?php $__empty_1 = true; $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="table-row cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50" @click="viewBatch = <?php echo e(Js::from($b)); ?>">
                                <td class="px-4 py-3 font-medium text-teal-700 dark:text-teal-400"><?php echo e($b->name); ?></td>
                                <td class="px-4 py-3"><?php echo e($b->type); ?> Batch</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-200 dark:bg-slate-700 rounded-full h-2.5">
                                            <div class="bg-teal-600 h-2.5 rounded-full" style="width: <?php echo e(min(100, ($b->students_count / max(1, $b->capacity)) * 100)); ?>%"></div>
                                        </div>
                                        <span class="text-xs text-slate-500 font-medium"><?php echo e($b->students_count); ?> / <?php echo e($b->capacity); ?></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($b->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800'); ?>">
                                        <?php echo e(ucfirst($b->status)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" @click.stop="viewBatch = <?php echo e(Js::from($b)); ?>" class="text-indigo-600 hover:text-indigo-800 transition" title="View Students"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></button>
                                        <button type="button" @click.stop="batch = <?php echo e(Js::from($b)); ?>" class="text-teal-600 hover:text-teal-800 transition">
                                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form method="POST" action="<?php echo e(route('computer-training.batches.destroy', $b)); ?>" onsubmit="return confirm('Delete this batch?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" @click.stop class="text-rose-600 hover:text-rose-800 transition">
                                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">No batches created yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Course Management -->
            <div x-show="activeSubTab === 'courses'" x-data="{ course: null, viewCourse: null }" class="surface overflow-hidden flex flex-col h-full">
                
                <!-- Course Modal -->
                <template x-teleport="body">
                    <div x-show="course !== null" 
                         class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                         style="display:none"
                         x-transition.opacity>
                        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="course = null">
                            <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative">
                                <form method="POST" :action="course && course.id ? '<?php echo e(url('/services/computer-training/courses')); ?>/' + course.id : '<?php echo e(route('computer-training.courses.store')); ?>'" class="p-6">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="_method" :value="course && course.id ? 'PUT' : 'POST'">
                                    
                                    <h2 class="mb-4 font-semibold text-lg flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                        <span x-text="course && course.id ? 'Edit Course' : 'Add New Course'"></span>
                                        <button type="button" @click="course = null" class="text-slate-400 hover:text-slate-600 transition">
                                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </h2>

                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Course Name</label>
                                            <input class="field" name="name" x-model="course.name" placeholder="e.g. Graphic Design" required>
                                        </div>
                                        <div class="space-y-2">
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
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Fee (Optional)</label>
                                            <input type="number" step="0.01" class="field" name="fee" x-model="course.fee" placeholder="0.00">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                                            <select class="field" name="status" x-model="course.status" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-primary w-full py-3 mt-6 text-base font-semibold" x-text="course && course.id ? 'Update Course' : 'Save Course'"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- View Course Details Modal -->
                <template x-teleport="body">
                    <div x-show="viewCourse !== null" 
                         class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                         style="display:none"
                         x-transition.opacity>
                        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="viewCourse = null">
                            <div class="w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative">
                                <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50 rounded-t-2xl">
                                    <div class="flex flex-col">
                                        <h2 class="font-bold text-xl text-slate-800 dark:text-slate-200" x-text="viewCourse?.name"></h2>
                                        <span class="text-sm text-slate-500 font-medium mt-1">
                                            <span x-text="viewCourse?.students?.length || 0"></span> Enrolled Students
                                        </span>
                                    </div>
                                    <button type="button" @click="viewCourse = null" class="text-slate-400 hover:text-slate-600 transition bg-white dark:bg-slate-800 rounded-full p-2 shadow-sm border border-slate-200 dark:border-slate-700">
                                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                                        <table class="w-full text-left text-sm whitespace-nowrap">
                                            <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                                <tr>
                                                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-400">ID</th>
                                                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-400">Student Name</th>
                                                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-400">Phone</th>
                                                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-400">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                                <template x-if="!viewCourse?.students || viewCourse.students.length === 0">
                                                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No students enrolled in this course yet.</td></tr>
                                                </template>
                                                <template x-for="s in viewCourse?.students" :key="s.id">
                                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                                        <td class="px-4 py-3 font-medium text-slate-700 dark:text-slate-300" x-text="s.id"></td>
                                                        <td class="px-4 py-3">
                                                            <div class="flex items-center gap-2">
                                                                <div class=" rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs" style="width: 2rem; height: 2rem;" x-text="s.name.charAt(0)"></div>
                                                                <span class="font-semibold text-slate-800 dark:text-slate-200" x-text="s.name"></span>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.phone"></td>
                                                        <td class="px-4 py-3">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                                  :class="{
                                                                      'bg-yellow-100 text-yellow-800': s.status === 'lead',
                                                                      'bg-blue-100 text-blue-800': s.status === 'admitted',
                                                                      'bg-green-100 text-green-800': s.status === 'active',
                                                                      'bg-purple-100 text-purple-800': s.status === 'completed',
                                                                      'bg-slate-100 text-slate-800': s.status === 'dropped',
                                                                  }"
                                                                  x-text="s.status.charAt(0).toUpperCase() + s.status.slice(1)">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-200">Course List</h3>
                    <button type="button" @click="course = { id: null, name: '', duration: '', fee: '', status: 'active' }" class="btn btn-primary shrink-0">Add New Course</button>
                </div>

                <table class="w-full text-left text-sm">
                    <thead class="table-head">
                        <tr>
                            <th class="px-4 py-3">Course Name</th>
                            <th class="px-4 py-3">Enrolled</th>
                            <th class="px-4 py-3">Duration</th>
                            <th class="px-4 py-3">Fee</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        <?php $__empty_1 = true; $__currentLoopData = $courseModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="table-row cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition" @click="viewCourse = <?php echo e(Js::from($c)); ?>">
                                <td class="px-4 py-3 font-medium text-teal-700 dark:text-teal-400"><?php echo e($c->name); ?></td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-indigo-600 rounded-full"><?php echo e($c->students_count); ?></span>
                                </td>
                                <td class="px-4 py-3"><?php echo e($c->duration ?? '-'); ?></td>
                                <td class="px-4 py-3"><?php echo e($c->fee ? number_format($c->fee, 2) : '-'); ?></td>
                                <td class="px-4 py-3">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($c->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800'); ?>">
                                        <?php echo e(ucfirst($c->status)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" @click.stop="viewCourse = <?php echo e(Js::from($c)); ?>" class="text-indigo-600 hover:text-indigo-800 transition" title="View Students"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></button>
                                        <button type="button" @click.stop="course = <?php echo e(Js::from($c)); ?>" class="text-teal-600 hover:text-teal-800 transition">
                                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form method="POST" action="<?php echo e(route('computer-training.courses.destroy', $c)); ?>" onsubmit="return confirm('Delete this course?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 transition">
                                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td class="px-4 py-5 text-center text-slate-500" colspan="5">No courses found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

                <section x-show="tab === 'attendance'" class="grid gap-5" x-data="{ 
            showBulkModal: false, 
            selectedCourse: '', 
            selectedBatchId: '', 
            attendanceDate: '<?php echo e(now()->toDateString()); ?>',
            students: [], 
            loading: false,
            
            fetchStudents() {
                if(!this.selectedBatchId) {
                    this.students = [];
                    return;
                }
                this.loading = true;
                fetch('<?php echo e(url('/services/computer-training/batches')); ?>/' + this.selectedBatchId + '/students')
                    .then(res => res.json())
                    .then(data => {
                        this.students = data.students.map(s => ({
                            student_id: s.id,
                            seat_number: s.seat_number,
                            name: s.name,
                            status: '', // default empty, checker must select
                            daily_rank: '' // default empty
                        }));
                        this.loading = false;
                    });
            }
        }">
            
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200">Daily Attendance History</h2>
                <button type="button" @click="showBulkModal = true; selectedCourse = ''; selectedBatchId = ''; students = [];" class="btn btn-primary px-5 py-2.5">
                    <svg class="size-5 mr-2 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Check Attendance
                </button>
            </div>

            <!-- Bulk Attendance Modal -->
            <template x-teleport="body">
                <div x-show="showBulkModal" 
                     class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-start justify-center p-4 sm:p-6 md:py-12" 
                     style="display:none"
                     x-transition.opacity>
                    
                    <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative flex flex-col max-h-[90vh]" @click.self="showBulkModal = false">
                        
                        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50 rounded-t-2xl shrink-0">
                            <h2 class="font-bold text-xl text-slate-800 dark:text-slate-200">Record Batch Attendance</h2>
                            <button type="button" @click="showBulkModal = false" class="text-slate-400 hover:text-slate-600 transition bg-white dark:bg-slate-800 rounded-full p-2 shadow-sm border border-slate-200 dark:border-slate-700">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <form method="POST" action="<?php echo e(route('computer-training.attendance.bulk')); ?>" class="flex flex-col overflow-hidden h-full">
                            <?php echo csrf_field(); ?>
                            
                            <div class="p-6 border-b border-slate-200 dark:border-slate-800 shrink-0 bg-white dark:bg-slate-900">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <div class="space-y-1 flex-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Date</label>
                                        <input type="date" class="field" name="attendance_date" x-model="attendanceDate" required>
                                    </div>
                                    <div class="space-y-1 flex-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Course</label>
                                        <select class="field" x-model="selectedCourse">
                                            <option value="">Select Course</option>
                                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($course); ?>"><?php echo e($course); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="space-y-1 flex-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Batch</label>
                                        <select class="field" name="batch_id" x-model="selectedBatchId" @change="fetchStudents()" required>
                                            <option value="">Select Batch</option>
                                            <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($batch->id); ?>"><?php echo e($batch->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="overflow-y-auto p-6 flex-1 bg-slate-50/50 dark:bg-slate-900/50 relative">
                                <div x-show="loading" class="absolute inset-0 flex justify-center items-center bg-white/80 dark:bg-slate-900/80 z-10 backdrop-blur-sm">
                                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600"></div>
                                </div>

                                <div x-show="selectedBatchId && students.length === 0 && !loading" class="text-center py-12 text-slate-500 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                                    <svg class=" mx-auto text-slate-400 mb-3" style="width: 3rem; height: 3rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    No students found in this batch.
                                </div>
                                
                                <div x-show="!selectedBatchId" class="text-center py-12 text-slate-500 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                                    Please select a Batch to load the student list.
                                </div>

                                <div x-show="students.length > 0" class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm">
                                    <table class="w-full text-left text-sm whitespace-nowrap">
                                        <thead class="bg-slate-100 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                                            <tr>
                                                <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300 w-20 text-center">Seat</th>
                                                <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Student Name</th>
                                                <th class="px-4 py-3 font-semibold text-green-700 dark:text-green-400 text-center w-24">Present</th>
                                                <th class="px-4 py-3 font-semibold text-red-700 dark:text-red-400 text-center w-24">Absent</th>
                                                <th class="px-4 py-3 font-semibold text-amber-700 dark:text-amber-500 w-40 text-center">Best Student</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                                            <template x-for="(s, index) in students" :key="s.student_id">
                                                <tr class="hover:bg-slate-100 dark:hover:bg-slate-800 transition duration-150">
                                                    <input type="hidden" :name="`attendances[${index}][student_id]`" :value="s.student_id">
                                                    
                                                    <td class="px-4 py-3 text-center">
                                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs" x-text="s.seat_number || '-'"></span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-3">
                                                            <div class=" rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs shrink-0" style="width: 2rem; height: 2rem;" x-text="s.name.charAt(0)"></div>
                                                            <span class="font-medium text-slate-800 dark:text-slate-200" x-text="s.name"></span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <label class="cursor-pointer group relative inline-flex items-center justify-center">
                                                            <input type="radio" :name="`attendances[${index}][status]`" value="present" x-model="s.status" class="peer sr-only" required>
                                                            <div class="px-5 py-1.5 rounded-full border border-slate-200 dark:border-slate-700 bg-slate-100/50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-semibold text-xs tracking-wide uppercase peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white peer-checked:shadow-[0_0_12px_rgba(34,197,94,0.4)] hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-300">
                                                                Present
                                                            </div>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <label class="cursor-pointer group relative inline-flex items-center justify-center">
                                                            <input type="radio" :name="`attendances[${index}][status]`" value="absent" x-model="s.status" class="peer sr-only" required>
                                                            <div class="px-5 py-1.5 rounded-full border border-slate-200 dark:border-slate-700 bg-slate-100/50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-semibold text-xs tracking-wide uppercase peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white peer-checked:shadow-[0_0_12px_rgba(239,68,68,0.4)] hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-300">
                                                                Absent
                                                            </div>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <select :name="`attendances[${index}][daily_rank]`" x-model="s.daily_rank" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                                                            <option value="">None</option>
                                                            <option value="1">1st Place 🏆</option>
                                                            <option value="2">2nd Place 🥈</option>
                                                            <option value="3">3rd Place 🥉</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="p-6 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 shrink-0 flex justify-end gap-3 rounded-b-2xl">
                                <button type="button" @click="showBulkModal = false" class="btn bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Cancel</button>
                                <button type="submit" class="btn btn-primary px-8" :disabled="students.length === 0 || loading">Save Attendance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>

            <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex flex-col sm:flex-row gap-3 mb-6 bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
                <input type="hidden" name="tab" value="attendance">
                
                <div class="flex-1">
                    <input type="date" name="attendance_date" value="<?php echo e(request('attendance_date')); ?>" class="field w-full" placeholder="Date">
                </div>
                
                <div class="flex-1">
                    <select name="attendance_course" class="field w-full">
                        <option value="">All Courses</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c); ?>" <?php echo e(request('attendance_course') == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="flex-1">
                    <select name="attendance_batch" class="field w-full">
                        <option value="">All Batches</option>
                        <?php $__currentLoopData = \App\Models\ComputerTrainingBatch::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($b->id); ?>" <?php echo e(request('attendance_batch') == $b->id ? 'selected' : ''); ?>><?php echo e($b->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div class="flex-[2]">
                    <div class="relative">
                        <input type="text" name="attendance_search" value="<?php echo e(request('attendance_search')); ?>" class="field w-full pl-10" placeholder="Search name, phone, ID...">
                        <svg class="size-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2 w-full sm:w-auto">Filter</button>
                    <?php if(request('attendance_date') || request('attendance_course') || request('attendance_batch') || request('attendance_search')): ?>
                        <a href="<?php echo e(url()->current()); ?>?tab=attendance" class="btn bg-slate-200 text-slate-700 hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600 px-4 py-2">Clear</a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="flex flex-col gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $attendanceRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="surface p-4 hover:shadow-md transition-shadow relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <?php if($attendance->daily_rank): ?>
                            <div class="absolute -right-6 top-4 bg-amber-500 text-white text-[10px] font-bold px-8 py-0.5 rotate-45 shadow-sm sm:hidden">
                                <?php echo e($attendance->daily_rank); ?><?php echo e($attendance->daily_rank == 1 ? 'st' : ($attendance->daily_rank == 2 ? 'nd' : 'rd')); ?>

                            </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center gap-4 flex-1">
                            <div class=" rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 font-bold text-lg shrink-0" style="width: 3rem; height: 3rem;">
                                <?php echo e(substr($attendance->student?->name ?? '?', 0, 1)); ?>

                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-slate-800 dark:text-slate-200 truncate text-base"><?php echo e($attendance->student?->name); ?></h3>
                                    <?php if($attendance->daily_rank): ?>
                                        <span class="hidden sm:inline-flex items-center gap-1 text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 px-2 py-0.5 rounded-full">
                                            🏆 <?php echo e($attendance->daily_rank); ?><?php echo e($attendance->daily_rank == 1 ? 'st' : ($attendance->daily_rank == 2 ? 'nd' : 'rd')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center gap-3 mt-1 text-sm text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <?php echo e($attendance->attendance_date->format('l, M j, Y')); ?>

                                    </div>
                                    <?php if($attendance->student?->batch): ?>
                                        <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-xs font-medium"><?php echo e($attendance->student->batch->name); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-800/50">
                            
                            <div class="flex items-center gap-4 text-xs font-medium">
                                <div class="flex flex-col items-center">
                                    <span class="text-slate-400 dark:text-slate-500 uppercase text-[10px] tracking-wider mb-0.5">Present</span>
                                    <span class="text-green-600 dark:text-green-400"><?php echo e($attendance->student?->present_count ?? 0); ?></span>
                                </div>
                                <div class="w-px h-6 bg-slate-200 dark:bg-slate-700"></div>
                                <div class="flex flex-col items-center">
                                    <span class="text-slate-400 dark:text-slate-500 uppercase text-[10px] tracking-wider mb-0.5">Absent</span>
                                    <span class="text-red-600 dark:text-red-400"><?php echo e($attendance->student?->absent_count ?? 0); ?></span>
                                </div>
                            </div>

                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider <?php echo e($attendance->status === 'present' ? 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400' : ($attendance->status === 'absent' ? 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400')); ?>">
                                <?php echo e($attendance->status); ?>

                            </span>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full surface p-12 text-center text-slate-500 border border-dashed border-slate-300 dark:border-slate-700">
                        <div class=" bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4" style="width: 4rem; height: 4rem;">
                            <svg class=" text-slate-400" style="width: 2rem; height: 2rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <p class="text-lg font-medium text-slate-700 dark:text-slate-300">No attendance records yet</p>
                        <p class="mt-1">Click "Check Attendance" above to record today's attendance.</p>
                    </div>
                <?php endif; ?>
            </div>
            <?php if($attendanceRecords->hasPages()): ?>
                <div class="mt-6 flex justify-end"><?php echo e($attendanceRecords->appends(['tab' => 'attendance'])->links()); ?></div>
            <?php endif; ?>
        </section>

        <section x-show="tab === 'classes'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="<?php echo e(route('computer-training.classes.store')); ?>" class="surface p-5">
                <?php echo csrf_field(); ?>
                <h2 class="mb-4 font-semibold">Class schedule</h2>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <input class="field" name="class_date" type="date" value="<?php echo e(now()->toDateString()); ?>" required title="Class Date">
                        <input class="field" name="starts_at" type="time" required title="Class Time">
                    </div>
                    <select class="field" name="course" required>
                        <option value="">Select Course</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course); ?>"><?php echo e($course); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <select class="field" name="batch_id" required>
                        <option value="">Select Batch</option>
                        <?php $__currentLoopData = \App\Models\ComputerTrainingBatch::withCount('students')->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($batch->id); ?>"><?php echo e($batch->name); ?> (<?php echo e($batch->students_count); ?> Students)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="grid grid-cols-2 gap-3">
                        <input class="field" name="instructor" placeholder="Trainer Name">
                        <input class="field" name="class_number" placeholder="Class Number (e.g. 01)">
                    </div>
                    <textarea class="field" name="topic" placeholder="Class Topic / Description" rows="3"></textarea>
                    <button class="btn btn-primary w-full">Save Schedule</button>
                </div>
            </form>
            <div class="grid gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $classSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="surface p-4">
                        <div class="flex justify-between gap-3">
                            <div>
                                <h3 class="font-semibold">
                                    <?php echo e($class->batch_name); ?>

                                    <?php if($class->class_number): ?>
                                        <span class="text-teal-600 dark:text-teal-400"> (Class <?php echo e($class->class_number); ?>)</span>
                                    <?php endif; ?>
                                </h3>
                                <p class="text-sm text-slate-500">
                                    <?php echo e($class->course); ?>

                                    <?php if($class->instructor): ?> · Trainer: <?php echo e($class->instructor); ?> <?php endif; ?>
                                    <?php if($class->topic): ?> · Topic: <?php echo e($class->topic); ?> <?php endif; ?>
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="font-medium"><?php echo e($class->class_date->format('M j, Y')); ?></p>
                                <p class="text-sm text-slate-500"><?php echo e(\Carbon\Carbon::parse($class->starts_at)->format('h:i A')); ?></p>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="surface p-5 text-center text-sm text-slate-500">No classes scheduled.</div>
                <?php endif; ?>
            </div>
            <div class="mt-4"><?php echo e($classSchedules->appends(['tab' => 'classes'])->links()); ?></div>
        </section>

        <section x-show="tab === 'exams'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="<?php echo e(route('computer-training.exams.store')); ?>" class="surface p-5">
                <?php echo csrf_field(); ?>
                <h2 class="mb-4 font-semibold">Class exam</h2>
                <div class="space-y-3">
                    <input class="field" name="title" placeholder="Exam title" required>
                    <select class="field" name="course" x-model="student.course" required><option value="">Course</option><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($course); ?>"><?php echo e($course); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                    <select class="field" name="class_schedule_id"><option value="">Related class</option><?php $__currentLoopData = $classSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($class->id); ?>"><?php echo e($class->batch_name); ?> - <?php echo e($class->class_date->format('M j')); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                    <input class="field" name="exam_date" type="date" required>
                    <input class="field" name="starts_at" type="time">
                    <input class="field" name="total_marks" type="number" value="100" min="1" required>
                    <textarea class="field" name="syllabus" placeholder="Syllabus"></textarea>
                    <button class="btn btn-primary w-full">Schedule exam</button>
                </div>
            </form>
            <div class="grid gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold"><?php echo e($exam->title); ?></h3><p class="text-sm text-slate-500"><?php echo e($exam->course); ?> · <?php echo e($exam->total_marks); ?> marks</p></div><p class="font-medium"><?php echo e($exam->exam_date->format('M j, Y')); ?></p></div></article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="surface p-5 text-center text-sm text-slate-500">No exams scheduled.</div>
                <?php endif; ?>
            </div>
            <div class="mt-4"><?php echo e($exams->appends(['tab' => 'exams'])->links()); ?></div>
        </section>

        <section x-show="tab === 'fees'" class="grid gap-5 xl:grid-cols-[24rem_1fr]" x-data="{ 
            feeCourse: '', 
            feeBatch: '', 
            feeStudent: '',
            totalAmount: '',
            paidAmount: '',
            feeType: ''
        }">
            <form method="POST" action="<?php echo e(route('computer-training.fees.store')); ?>" class="surface p-5">
                <?php echo csrf_field(); ?>
                <h2 class="mb-4 font-semibold">Fee management</h2>
                <div class="space-y-3">
                    <select class="field" x-model="feeCourse" @change="feeStudent = ''">
                        <option value="">All Courses</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course); ?>"><?php echo e($course); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <select class="field" x-model="feeBatch" @change="feeStudent = ''">
                        <option value="">All Batches</option>
                        <?php $__currentLoopData = \App\Models\ComputerTrainingBatch::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($b->id); ?>"><?php echo e($b->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <select class="field" name="student_id" x-model="feeStudent" required>
                        <option value="">Select Student</option>
                        <template x-for="student in <?php echo e(Js::from(\App\Models\ComputerTrainingStudent::select('id', 'name', 'course', 'batch_id')->get())); ?>.filter(s => (!feeCourse || s.course === feeCourse) && (!feeBatch || s.batch_id == feeBatch))" :key="student.id">
                            <option :value="student.id" x-text="student.name"></option>
                        </template>
                    </select>

                    <select class="field" name="fee_type" x-model="feeType" required>
                        <option value="">Select Fee Type</option>
                        <option value="Admission">Admission</option>
                        <option value="Registration">Registration</option>
                        <option value="Exam Fee">Exam Fee</option>
                        <option value="Tour">Tour</option>
                        <option value="Donation">Donation</option>
                    </select>

                    <div class="grid grid-cols-2 gap-3">
                        <input class="field" name="amount" type="number" step="0.01" min="0" placeholder="Total amount" x-model="totalAmount" required>
                        <input class="field" name="paid_amount" type="number" step="0.01" min="0" placeholder="Paid amount" x-model="paidAmount">
                    </div>
                    
                    <div class="text-sm font-medium text-slate-700 dark:text-slate-300 py-1">
                        Due: <span x-text="Math.max(0, (parseFloat(totalAmount) || 0) - (parseFloat(paidAmount) || 0)).toFixed(2)" class="text-red-500 font-bold"></span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <input class="field" name="due_date" type="date" required title="Due Date">
                        <input class="field" name="paid_at" type="date" title="Paid At">
                    </div>
                    
                    <select class="field" name="status">
                        <option value="due">Due</option>
                        <option value="partial">Partial</option>
                        <option value="paid">Paid</option>
                        <option value="waived">Waived</option>
                    </select>
                    
                    <input class="field" name="payment_method" placeholder="Payment method">
                    <textarea class="field" name="remarks" placeholder="Remarks"></textarea>
                    <button class="btn btn-primary w-full">Save fee</button>
                </div>
            </form>
            <div class="flex flex-col gap-3">
                <form method="GET" class="flex gap-3 items-center">
                    <input type="hidden" name="tab" value="fees">
                    <select class="field py-1" name="fee_status" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="paid" <?php echo e(request('fee_status') === 'paid' ? 'selected' : ''); ?>>Paid</option>
                        <option value="due" <?php echo e(request('fee_status') === 'due' ? 'selected' : ''); ?>>Due / Partial</option>
                    </select>
                </form>
                
                <div class="grid gap-3">
                    <?php $__empty_1 = true; $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article class="surface p-4">
                            <div class="flex justify-between gap-3">
                                <div>
                                    <h3 class="font-semibold <?php echo e($fee->amount > $fee->paid_amount ? 'text-red-600 dark:text-red-400' : ''); ?>">
                                        <?php echo e($fee->student?->name); ?>

                                    </h3>
                                    <p class="text-sm text-slate-500">
                                        <?php echo e($fee->fee_type ?? 'Fee'); ?> · <?php echo e(ucfirst($fee->status)); ?>

                                        <?php if($fee->amount > $fee->paid_amount): ?>
                                            · Due Date: <?php echo e($fee->due_date->format('M j, Y')); ?>

                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="font-semibold text-teal-600 dark:text-teal-400"><?php echo e(number_format($fee->paid_amount, 2)); ?> Paid</p>
                                    <p class="text-sm text-slate-500">of <?php echo e(number_format($fee->amount, 2)); ?> Total</p>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="surface p-5 text-center text-sm text-slate-500">No fee records.</div>
                    <?php endif; ?>
                </div>
                <div class="mt-4"><?php echo e($fees->appends(['tab' => 'fees', 'fee_status' => request('fee_status')])->links()); ?></div>
            </div>
        </section>

        <section x-show="tab === 'marketing'" class="grid gap-5">
            <!-- Modal Container -->
            <template x-teleport="body">
                <div x-show="marketingLead !== null" 
                     class="fixed inset-0 z-[100] grid place-items-center bg-slate-950/60 backdrop-blur-sm p-4" 
                     style="display:none"
                     x-transition.opacity>
                    <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden relative" 
                         @click.away="marketingLead = null" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0" 
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-200" 
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0">
                    <form method="POST" :action="marketingLead && marketingLead.id ? '<?php echo e(url('/services/computer-training/marketing')); ?>/' + marketingLead.id : '<?php echo e(route('computer-training.marketing.store')); ?>'" class="p-5">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="_method" :value="marketingLead && marketingLead.id ? 'PUT' : 'POST'">
                        <h2 class="mb-4 font-semibold text-lg flex justify-between items-center">
                            <span x-text="marketingLead && marketingLead.id ? 'Edit Student' : 'Add New Student'"></span>
                            <button type="button" @click="marketingLead = null" class="text-slate-400 hover:text-slate-600 transition">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </h2>
                        <div class="space-y-3">
                            <input class="field" name="name" x-model="marketingLead.name" placeholder="Student name" required>
                            <input class="field" name="phone" x-model="marketingLead.phone" placeholder="Phone">
                            <select class="field" name="interested_course" x-model="marketingLead.interested_course">
                                <option value="">Interested course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course); ?>"><?php echo e($course); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select class="field" name="duration" x-model="marketingLead.duration">
                                <option value="">Duration</option>
                                <option value="1 month">1 month</option>
                                <option value="2 months">2 months</option>
                                <option value="3 months">3 months</option>
                                <option value="4 months">4 months</option>
                                <option value="5 months">5 months</option>
                                <option value="6 months">6 months</option>
                            </select>
                            <input class="field" name="source" x-model="marketingLead.source" placeholder="Source">
                            <select class="field" name="status" x-model="student.status" x-model="marketingLead.status">
                                <option value="new">New</option>
                                <option value="contacting">Contacting</option>
                                <option value="interested">Interested</option>
                                <option value="admitted">Admitted</option>
                                <option value="not interested">Not Interested</option>
                            </select>
                            
                            <template x-if="marketingLead.status === 'contacting'">
                                <select class="field" name="call_status" x-model="marketingLead.call_status">
                                    <option value="">Select call status</option>
                                    <option value="phone not received">Phone not received</option>
                                    <option value="call rejected">Call rejected</option>
                                    <option value="number busy">Number busy</option>
                                    <option value="wrong number">Wrong number</option>
                                </select>
                            </template>
                            
                            <template x-if="marketingLead.status === 'interested'">
                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">When will come</label>
                                    <input class="field" name="next_follow_up_at" type="datetime-local" :value="marketingLead && marketingLead.next_follow_up_at ? marketingLead.next_follow_up_at.replace(' ', 'T').slice(0,16) : ''" @change="marketingLead.next_follow_up_at = $event.target.value">
                                </div>
                            </template>
                            
                            <textarea class="field" name="notes" x-model="marketingLead.notes" placeholder="Imported Info / Old Notes"></textarea>
                            <textarea class="field" name="remarks" x-model="marketingLead.remarks" placeholder="Marketing Note"></textarea>
                            <button class="btn btn-primary w-full" x-text="marketingLead && marketingLead.id ? 'Update student' : 'Save student'"></button>
                        </div>
                    </form>
                </div>
            </div>
            </template>
            
            <div class="grid gap-3">
                <div class="surface rounded-xl overflow-hidden shadow-sm shadow-slate-200/50 dark:shadow-none focus-within:ring-2 focus-within:ring-teal-500/50 transition-all">
                    <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex flex-col sm:flex-row items-center w-full bg-white dark:bg-slate-950">
                        <input type="hidden" name="tab" value="marketing">
                        <?php if(request()->has('per_page')): ?>
                            <input type="hidden" name="per_page" value="<?php echo e(request('per_page')); ?>">
                        <?php endif; ?>
                        
                        <div class="relative flex-1 w-full sm:border-r border-slate-200 dark:border-slate-800 flex items-center">
                            <svg class="size-5 absolute left-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="marketing_search" value="<?php echo e(request('marketing_search')); ?>" placeholder="Search by name or mobile..." class="w-full bg-transparent border-0 focus:ring-0 pl-12 py-3.5 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 outline-none">
                            <?php if(request('marketing_search')): ?>
                                <a href="<?php echo e(url()->current()); ?>?tab=marketing&marketing_status=<?php echo e(request('marketing_status')); ?>&marketing_source=<?php echo e(request('marketing_source')); ?>&per_page=<?php echo e(request('per_page')); ?>" class="absolute right-3 p-1 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 dark:hover:text-slate-300 transition">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex items-center w-full sm:w-auto pl-3 pr-2 py-2 sm:py-0 border-t sm:border-t-0 border-slate-200 dark:border-slate-800">
                            <select name="marketing_status" class="bg-transparent border-0 text-sm font-medium text-slate-600 dark:text-slate-300 focus:ring-0 outline-none cursor-pointer hover:text-slate-900 dark:hover:text-white transition w-full sm:w-auto [&>option]:dark:bg-slate-900" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="new" === 'new')>New</option>
                                <option value="contacting" === 'contacting')>Contacting</option>
                                <option value="interested" === 'interested')>Interested</option>
                                <option value="admitted" === 'admitted')>Admitted</option>
                                <option value="not interested" === 'not interested')>Not Interested</option>
                            </select>
                            
                            <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 hidden sm:block mx-1"></div>
                            
                            <select name="marketing_source" class="bg-transparent border-0 text-sm font-medium text-slate-600 dark:text-slate-300 focus:ring-0 outline-none cursor-pointer hover:text-slate-900 dark:hover:text-white transition w-full sm:w-auto mt-2 sm:mt-0 [&>option]:dark:bg-slate-900" onchange="this.form.submit()">
                                <option value="">All Schools</option>
                                <?php $__currentLoopData = $marketingSources ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($source); ?>" === $source)><?php echo e($source); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            
                            <button type="submit" class="hidden sm:inline-flex ml-2 items-center justify-center rounded-lg bg-teal-600 p-2 text-white hover:bg-teal-700 transition shadow-sm shadow-teal-900/10">
                                <svg class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="flex flex-col gap-4 surface p-4 sm:flex-row sm:items-center sm:justify-between">
                    <button type="button" @click="marketingLead = { id: null, name: '', phone: '', interested_course: '', duration: '', source: '', status: 'new', call_status: '', next_follow_up_at: '', notes: '', remarks: '' }" class="btn btn-primary shrink-0">Add New Student</button>
                    <form method="POST" action="<?php echo e(route('computer-training.marketing.sync-google-sheet')); ?>" class="flex shrink-0">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700 shrink-0 gap-2 flex items-center" onclick="this.disabled=true; this.innerHTML='Syncing...'; this.form.submit();">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Sync Google Sheet
                        </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('computer-training.marketing.import')); ?>" enctype="multipart/form-data" class="flex flex-1 items-center justify-end gap-2">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="tab" value="marketing">
                        <input type="file" name="file" accept=".xlsx,.csv,.xls" class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-md file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-teal-700 hover:file:bg-teal-100 dark:file:bg-teal-900/50 dark:file:text-teal-400 dark:text-slate-400" required>
                        <button type="submit" class="btn btn-primary shrink-0">Import</button>
                    </form>
                    <div class="flex items-center gap-2 shrink-0">
                        <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex items-center gap-2">
                            <input type="hidden" name="tab" value="marketing">
                            <?php if(request()->has('marketing_search')): ?>
                                <input type="hidden" name="marketing_search" value="<?php echo e(request('marketing_search')); ?>">
                            <?php endif; ?>
                            <?php if(request()->has('marketing_status')): ?>
                                <input type="hidden" name="marketing_status" value="<?php echo e(request('marketing_status')); ?>">
                            <?php endif; ?>
                            <select name="per_page" onchange="this.form.submit()" class="field text-sm py-1.5 pl-3 pr-8 w-auto border border-slate-300 dark:border-slate-700">
                                <option value="10" == 10)>10</option>
                                <option value="25" == 25)>25</option>
                                <option value="50" == 50)>50</option>
                                <option value="100" == 100)>100</option>
                            </select>
                        </form>
                        <a href="<?php echo e(route('computer-training.marketing.export')); ?>" class="btn rounded-md border border-slate-300 px-4 py-1.5 text-sm font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Export</a>
                    </div>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article @click="marketingLead = <?php echo e(Js::from($lead)); ?>" class="surface p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        <div class="flex justify-between gap-3">
                            <div>
                                <h3 class="font-semibold"><?php echo e($lead->name); ?></h3>
                                <p class="text-sm text-slate-500"><?php echo e($lead->phone ?? 'No phone'); ?> · <?php echo e($lead->interested_course ?? 'No course'); ?><?php if($lead->duration): ?> · <?php echo e($lead->duration); ?><?php endif; ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium"><?php echo e(ucfirst($lead->status)); ?></p>
                                <p class="text-sm text-slate-500"><?php echo e($lead->source ?? 'Direct'); ?></p>
                                <?php if($lead->status === 'contacting' && $lead->call_status): ?>
                                    <p class="text-xs text-rose-500 font-medium mt-1"><?php echo e(ucfirst($lead->call_status)); ?></p>
                                <?php elseif($lead->status === 'interested' && $lead->next_follow_up_at): ?>
                                    <p class="text-xs text-emerald-600 font-medium mt-1">Visit: <?php echo e($lead->next_follow_up_at->format('M j, Y g:i A')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($lead->notes || $lead->remarks): ?>
                            <div class="mt-3 border-t border-slate-100 pt-3 dark:border-slate-800 text-sm text-slate-600 dark:text-slate-400 whitespace-pre-wrap"><?php if($lead->notes): ?><?php echo e($lead->notes); ?><?php endif; ?>
<?php if($lead->remarks): ?>

<span class="font-medium text-slate-800 dark:text-slate-200">Note:</span> <?php echo e($lead->remarks); ?><?php endif; ?></div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="surface p-5 text-center text-sm text-slate-500">No marketing leads.</div>
                <?php endif; ?>
            </div>
            <div class="mt-4"><?php echo e($leads->appends(['tab' => 'marketing', 'marketing_search' => request('marketing_search'), 'marketing_status' => request('marketing_status'), 'marketing_source' => request('marketing_source')])->links()); ?></div>
        </section>

        <section x-show="tab === 'reminders'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="<?php echo e(route('computer-training.reminders.store')); ?>" class="surface p-5">
                <?php echo csrf_field(); ?>
                <h2 class="mb-4 font-semibold">To-do / reminder</h2>
                <div class="space-y-3">
                    <input class="field" name="title" placeholder="Title" required>
                    <textarea class="field" name="purpose" placeholder="Task or reminder purpose" required></textarea>
                    <textarea class="field" name="follow_up_notes" placeholder="Follow-up notes"></textarea>
                    <input class="field" name="remind_at" type="datetime-local" required>
                    <button class="btn btn-primary w-full">Save reminder</button>
                </div>
            </form>
            <div class="grid gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold"><?php echo e($reminder->title); ?></h3><p class="text-sm text-slate-500"><?php echo e($reminder->purpose); ?></p></div><div class="text-right"><p class="font-medium"><?php echo e($reminder->remind_at->format('M j, Y')); ?></p><p class="text-sm text-slate-500"><?php echo e($reminder->remind_at->diffForHumans()); ?></p></div></div></article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="surface p-5 text-center text-sm text-slate-500">No pending reminders.</div>
                <?php endif; ?>
            </div>
            <div class="mt-4"><?php echo e($reminders->appends(['tab' => 'reminders'])->links()); ?></div>
        </section>

        <section x-show="tab === 'notices'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="<?php echo e(route('computer-training.notices.store')); ?>" class="surface p-5">
                <?php echo csrf_field(); ?>
                <h2 class="mb-4 font-semibold">Notice</h2>
                <div class="space-y-3">
                    <input class="field" name="title" placeholder="Notice title" required>
                    <textarea class="field" name="body" placeholder="Notice body" required></textarea>
                    <input class="field" name="publish_date" type="date" value="<?php echo e(now()->toDateString()); ?>" required>
                    <select class="field" name="audience"><option value="all">All</option><option value="students">Students</option><option value="leads">Leads</option><option value="staff">Staff</option></select>
                    <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300"><input class="rounded border-slate-300 text-teal-600 focus:ring-teal-500" type="checkbox" name="is_active" value="1" checked> Active</label>
                    <button class="btn btn-primary w-full">Publish notice</button>
                </div>
            </form>
            <div class="grid gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold"><?php echo e($notice->title); ?></h3><p class="mt-1 text-sm text-slate-500"><?php echo e($notice->body); ?></p></div><div class="text-right"><p class="font-medium"><?php echo e(ucfirst($notice->audience)); ?></p><p class="text-sm text-slate-500"><?php echo e($notice->publish_date->format('M j, Y')); ?></p></div></div></article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="surface p-5 text-center text-sm text-slate-500">No notices.</div>
                <?php endif; ?>
            </div>
            <div class="mt-4"><?php echo e($notices->appends(['tab' => 'notices'])->links()); ?></div>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/services/computer-training.blade.php ENDPATH**/ ?>