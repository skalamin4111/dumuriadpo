<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'আয়ের উৎস ঘোষণা-পত্র - Details']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'আয়ের উৎস ঘোষণা-পত্র - Details']); ?>
    <style>
        /* Common page break rules for print */
        @media print {
            aside,
            header,
            .no-print,
            .btn,
            nav {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            @page {
                size: A4;
                margin: 0;
            }

            /* Toggle printing visibility based on mode class */
            .print-mode-wrapper {
                display: block !important;
            }

            .print-digital-mode .print-pdf-only {
                display: none !important;
            }

            .print-pdf-mode .print-digital-only {
                display: none !important;
            }

            .print-page, .pdf-overlay-page {
                width: 210mm !important;
                height: 297mm !important;
                margin: 0 !important;
                padding: 20mm 15mm !important;
                box-shadow: none !important;
                border: none !important;
                page-break-after: always !important;
                break-after: page !important;
                box-sizing: border-box;
                display: flex !important;
                flex-direction: column;
                justify-content: space-between;
            }

            .pdf-overlay-page {
                padding: 0 !important; /* PDF overlays should not have page padding */
                position: relative !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-page:last-child, .pdf-overlay-page:last-child {
                page-break-after: avoid !important;
                break-after: avoid !important;
            }
        }

        /* Screen view preview styling */
        .print-preview-container {
            max-width: 210mm;
            margin: 0 auto;
        }

        .print-page {
            background: #fff;
            color: #1a1a1a;
            font-family: 'SolaimanLipi', 'Kalpurush', 'Siyam Rupali', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.7;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25mm 20mm;
            margin-bottom: 24px;
            box-sizing: border-box;
            position: relative;
        }

        /* PDF Scanned Background Overlay View styling */
        .pdf-overlay-page {
            position: relative;
            width: 210mm;
            height: 297mm;
            margin: 0 auto 24px auto;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background-color: #fff;
            color: #000;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            box-sizing: border-box;
            overflow: hidden;
        }

        .pdf-overlay-page.page-1 {
            background-image: url("<?php echo e(str_replace(['http:', 'https:'], '', asset('bank-asia/page-1.png'))); ?>");
        }

        .pdf-overlay-page.page-2 {
            background-image: url("<?php echo e(str_replace(['http:', 'https:'], '', asset('bank-asia/page-2.png'))); ?>");
        }

        /* Absolutely positioned overlay labels */
        .overlay-field {
            position: absolute;
            font-family: 'SolaimanLipi', 'Kalpurush', 'Siyam Rupali', Arial, sans-serif;
            font-size: 14.5px;
            font-weight: bold;
            color: #0f172a;
            pointer-events: none;
            white-space: nowrap;
        }

        .overlay-field.textarea-field {
            white-space: normal;
            line-height: 1.5;
        }

        .bn-text-justify {
            text-align: justify;
            text-justify: inter-word;
        }

        .underline-dotted {
            border-bottom: 1.5px dotted #334155;
            padding-bottom: 1px;
            font-weight: 700;
            color: #0f172a;
        }

        .checkbox-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            border: 1.5px solid #000;
            margin-right: 6px;
            font-size: 10px;
            font-weight: bold;
            vertical-align: middle;
        }

        .awareness-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .awareness-table td {
            border: 1.5px solid #000;
            padding: 8px 12px;
            font-size: 14px;
        }

        .awareness-table td.label-cell {
            font-weight: bold;
            width: 25%;
        }
    </style>

    <div x-data="{ activeTab: 'pdf' }">
        
        <div class="mb-6 flex items-center justify-between no-print">
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('bank-asia.ac-creations.index')); ?>" class="btn btn-muted flex items-center gap-2">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    তালিকায় ফিরে যান
                </a>
                
                
                <div class="inline-flex rounded-lg p-1 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    <button @click="activeTab = 'pdf'" :class="activeTab === 'pdf' ? 'bg-white dark:bg-slate-900 shadow-sm text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-600 dark:text-slate-400'" class="px-4 py-1.5 text-xs rounded-md transition duration-200">
                        পিডিএফ ফিল্ড ভিউ (PDF Overlay)
                    </button>
                    <button @click="activeTab = 'digital'" :class="activeTab === 'digital' ? 'bg-white dark:bg-slate-900 shadow-sm text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-600 dark:text-slate-400'" class="px-4 py-1.5 text-xs rounded-md transition duration-200">
                        ডিজিটাল প্রিন্ট ভিউ (HTML Design)
                    </button>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="<?php echo e(route('bank-asia.ac-creations.edit', $acCreation)); ?>" class="btn btn-muted flex items-center gap-2">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    সম্পাদনা (Edit)
                </a>
                <button onclick="window.print()" class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white border-transparent flex items-center gap-2">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg>
                    প্রিন্ট করুন (Print)
                </button>
            </div>
        </div>

        <div class="print-mode-wrapper" :class="activeTab === 'pdf' ? 'print-pdf-mode' : 'print-digital-mode'">
            
            
            <div class="print-pdf-only" x-show="activeTab === 'pdf'">
                
                <div class="pdf-overlay-page page-1">
                    
                    <div class="overlay-field" style="top: 14.4%; left: 17.0%;">
                        <?php echo e($acCreation->date->format('d-m-Y')); ?>

                    </div>

                    
                    <?php if($acCreation->account_type === 'new'): ?>
                        <div class="overlay-field font-bold text-lg" style="top: 13.2%; left: 90.5%;">✔</div>
                    <?php else: ?>
                        <div class="overlay-field font-bold text-lg" style="top: 15.9%; left: 90.5%;">✔</div>
                    <?php endif; ?>

                    
                    <div class="overlay-field" style="top: 32.6%; left: 16.5%;">
                        <?php echo e($acCreation->applicant_name_bn); ?>

                    </div>

                    
                    <div class="overlay-field" style="top: 32.6%; left: 59%;">
                        <?php echo e($acCreation->father_name); ?>

                    </div>

                    
                    <div class="overlay-field" style="top: 35.7%; left: 15.5%;">
                        <?php echo e($acCreation->mother_name); ?>

                    </div>

                    
                    <div class="overlay-field font-mono" style="top: 38.8%; left: 12.5%; font-size: 15px;">
                        <?php echo e($acCreation->nid_number); ?>

                    </div>

                    
                    <div class="overlay-field textarea-field" style="top: 39.0%; left: 47.5%; width: 68%;">
                        <?php echo e($acCreation->present_address); ?>

                    </div>

                    
                    <div class="overlay-field textarea-field" style="top: 41.7%; left: 21.5%; width: 33%;">
                        <?php echo e($acCreation->outlet_name_address); ?>

                    </div>

                    
                    <div class="overlay-field" style="top: 45%; left: 12.5%;">
                        <?php echo e($acCreation->occupation); ?>

                    </div>

                    
                    <div class="overlay-field" style="top: 48.2%; left: 15.5%;">
                        <?php echo e($acCreation->source_of_funds); ?>

                    </div>

                    
                    <div class="overlay-field font-mono" style="top: 48%; left: 67.5%; font-size: 15px;">
                        <?php echo e(number_format($acCreation->monthly_income, 0)); ?>

                    </div>

                    
                    <div class="overlay-field font-mono text-base" style="top: 75.2%; left: 19.0%;">
                        <?php echo e($acCreation->mobile_number); ?>

                    </div>

                    
                    <div class="overlay-field font-mono text-base" style="top: 78.4%; left: 19.0%;">
                        <?php echo e($acCreation->account_number); ?>

                    </div>

                    
                    <div class="absolute flex items-center justify-center" style="top: 77.0%; left: 15.0%; width: 150px; height: 65px;">
                        <?php if($acCreation->applicant_signature_path): ?>
                            <img src="<?php echo e(str_replace(['http:', 'https:'], '', asset('storage/' . $acCreation->applicant_signature_path))); ?>" class="max-w-full max-h-full object-contain">
                        <?php endif; ?>
                    </div>

                    
                    <div class="overlay-field" style="top: 78.5%; left: 78.5%; line-height: 1.4;">
                        <div style="display:none;">নাম: <?php echo e($acCreation->agent_name ?? 'মোঃ আলামিন'); ?></div>
                        <div style="display:none;">Designation: <?php echo e($acCreation->agent_designation ?? 'সি এস ও'); ?></div>
                        <div><?php echo e($acCreation->agent_mobile ?? '01955801666'); ?></div>
                    </div>
                </div>

                
                <div class="pdf-overlay-page page-2">
                    
                    <div class="overlay-field" style="top: 13.1%; left: 19.0%; font-size:16px;">
                        <?php echo e($acCreation->date->format('d')); ?><span style="margin:0 15px"></span><?php echo e($acCreation->date->format('m')); ?><span style="margin:0 16px"></span><?php echo e($acCreation->date->format('Y')); ?>

                    </div>

                    
                    <div class="overlay-field" style="top: 70.3%; left: 38.0%; font-size:18px;">
                        <?php echo e($acCreation->applicant_name_bn); ?>

                    </div>

                    
                    <div class="overlay-field font-mono text-base" style="top: 74.4%; left: 38.0%; font-size:16px;">
                        <?php echo e($acCreation->customer_id ?? '---'); ?>

                    </div>

                    
                    <div class="overlay-field font-mono text-base" style="top: 78.2%; left: 38.0%; font-size:16px;">
                        <?php echo e($acCreation->mobile_number); ?>

                    </div>

                    
                    <div class="absolute flex items-center justify-center" style="top: 70.3%; left: 69.0%; width: 190px; height: 75px;">
                        <?php if($acCreation->applicant_signature_path): ?>
                            <img src="<?php echo e(str_replace(['http:', 'https:'], '', asset('storage/' . $acCreation->applicant_signature_path))); ?>" class="max-w-full max-h-full object-contain">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="print-digital-only" x-show="activeTab === 'digital'">
                
                <div class="print-page flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-6 border-b border-black pb-4">
                            <div>
                                <h1 class="text-2xl font-bold tracking-wider text-black">ব্যাংক এশিয়া লিমিটেড</h1>
                                <p class="text-xs font-semibold text-slate-700">এজেন্ট ব্যাংকিং ডিভিশন</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs border border-black px-2 py-1 font-bold">পরিশিষ্ট - ক</span>
                            </div>
                        </div>

                        <div class="text-center my-6">
                            <h2 class="text-xl font-bold border-y border-black py-1.5 bg-slate-50 text-black">আয়ের উৎস ঘোষণা-পত্র</h2>
                            <p class="text-xs font-semibold mt-1 text-slate-700">(নতুন হিসাব খোলা/ডরমেন্ট হিসাব সচল করার ক্ষেত্রে প্রযোজ্য)</p>
                        </div>

                        <div class="flex justify-between items-center mb-6 text-sm">
                            <div>
                                <strong>তারিখ:</strong> <span class="underline-dotted px-2"><?php echo e($acCreation->date->format('d/m/Y')); ?></span>
                            </div>
                            <div class="flex gap-6">
                                <div>
                                    <span class="checkbox-box"><?php echo $acCreation->account_type === 'new' ? '&#10003;' : '&nbsp;'; ?></span>
                                    <span>নতুন হিসাব</span>
                                </div>
                                <div>
                                    <span class="checkbox-box"><?php echo $acCreation->account_type === 'dormant' ? '&#10003;' : '&nbsp;'; ?></span>
                                    <span>ডরমেন্ট হিসাব সচলকরণ</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 bn-text-justify text-base leading-relaxed text-black">
                            <p>
                                আমি <span class="underline-dotted px-2"><?php echo e($acCreation->applicant_name_bn); ?></span>, 
                                পিতা/স্বামীর নামঃ <span class="underline-dotted px-2"><?php echo e($acCreation->father_name); ?></span>, 
                                মাতার নামঃ <span class="underline-dotted px-2"><?php echo e($acCreation->mother_name); ?></span>, 
                                জাতীয় পরিচয়পত্র/পাসপোর্ট/জন্ম নিবন্ধন নম্বরঃ <span class="underline-dotted px-2 font-mono"><?php echo e($acCreation->nid_number); ?></span>, 
                                বর্তমান ঠিকানা: <span class="underline-dotted px-2"><?php echo e($acCreation->present_address); ?></span>, 
                                আপনার <span class="underline-dotted px-2"><?php echo e($acCreation->outlet_name_address); ?></span> এজেন্ট আউটলেটের সেবা গ্রহণকারী।
                            </p>

                            <p>
                                বর্তমানে আমার পেশা <span class="underline-dotted px-2"><?php echo e($acCreation->occupation); ?></span>। 
                                আমার পেশার প্রমাণস্বরূপ কোন দাপ্তরিক ডকুমেন্ট নেই। আমার আয়ের উৎস মূলত 
                                <span class="underline-dotted px-2"><?php echo e($acCreation->source_of_funds); ?></span> 
                                যেখান থেকে আমার আনুমানিক মাসিক আয় <span class="underline-dotted px-2 font-mono"><?php echo e(number_format($acCreation->monthly_income, 0)); ?></span> টাকা।
                            </p>

                            <p>
                                উল্লেখিত আয়কেই আমার আয়ের উৎস হিসেবে বিবেচনা করতঃ লেনদেন পরিচালনা সংক্রান্ত ব্যাপারে সহযোগিতা প্রদানে মর্জি হয়।
                            </p>

                            <p>
                                আমার আয়ের উৎস সংক্রান্ত প্রদত্ত তথ্যাদি সঠিক ও নির্ভুল। উক্ত তথ্যাদি অসত্য বলে প্রমানিত হলে সকল প্রকার দায়ভার আমার ওপর বর্তাবে এবং authorities এর যেকোন সিদ্ধান্ত আমি মেনে নিতে বাধ্য থাকবো।
                            </p>
                        </div>
                    </div>

                    <div class="mt-16">
                        <div class="grid grid-cols-2 gap-8 text-center text-sm">
                            <div class="flex flex-col items-center justify-end">
                                <div class="h-16 flex items-center justify-center mb-2">
                                    <?php if($acCreation->applicant_signature_path): ?>
                                        <img src="<?php echo e(str_replace(['http:', 'https:'], '', asset('storage/' . $acCreation->applicant_signature_path))); ?>" alt="Signature" class="max-h-16 object-contain">
                                    <?php else: ?>
                                        <div class="w-32 h-10 border-b border-dashed border-slate-400"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="border-t border-black w-56 pt-1 font-bold">গ্রাহকের স্বাক্ষর</div>
                            </div>
                            
                            <div class="flex flex-col items-center justify-end">
                                <div class="h-16 flex flex-col justify-end text-left text-xs text-slate-700 w-56 pb-2">
                                    <div>নাম: <?php echo e($acCreation->agent_name ?? 'মোঃ আলামিন'); ?></div>
                                    <div>পদবী: <?php echo e($acCreation->agent_designation ?? 'সি এস ও'); ?></div>
                                    <div>মোবাইল: <?php echo e($acCreation->agent_mobile ?? '01955801666'); ?></div>
                                </div>
                                <div class="border-t border-black w-56 pt-1 font-bold">যাচাইকারী কর্মকর্তার স্বাক্ষর ও সিল</div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="print-page flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-6 border-b border-black pb-4">
                            <div>
                                <h1 class="text-2xl font-bold tracking-wider text-black">ব্যাংক এশিয়া লিমিটেড</h1>
                                <p class="text-xs font-semibold text-slate-700">এজেন্ট ব্যাংকিং ডিভিশন</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs border border-black px-2 py-1 font-bold">পরিশিষ্ট - খ</span>
                            </div>
                        </div>

                        <div class="text-center my-6">
                            <h2 class="text-xl font-bold border-y border-black py-1.5 bg-slate-50 text-black">হিসাব পরিচালনা ও লেনদেন সংক্রান্ত সচেতনতা</h2>
                        </div>

                        <div class="space-y-4 text-black text-sm">
                            <div class="flex items-start gap-2">
                                <span class="font-bold">১.</span>
                                <p class="bn-text-justify">হিসাব খোলার সময় আপনার আঙ্গুলের ছাপ, পরিচিতিপত্র, মোবাইল নম্বর এবং লাইভ ছবি নিশ্চিত করুন।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">২.</span>
                                <p class="bn-text-justify">এজেন্ট আউটলেটে জমার ক্ষেত্রে আঙ্গুলের ছাপের প্রয়োজন হয় না।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">৩.</span>
                                <p class="bn-text-justify">আউটলেট হতে সকল প্রকার অর্থ উত্তোলন আঙ্গুলের ছাপ ও OTP দ্বারা নিশ্চিত করবেন।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">৪.</span>
                                <p class="bn-text-justify">আঙ্গুলের ছাপ আপনার লেনদেনের নিরাপত্তা নিশ্চিত করে। তাই অযথা আঙ্গুলের ছাপ দিবেন না।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">৫.</span>
                                <p class="bn-text-justify">আপনার মোবাইল নম্বর প্রদান করুন এবং SMS এর মাধ্যমে বিলের জমা নিশ্চিত হউন।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">৬.</span>
                                <p class="bn-text-justify">লেনদেনের পর এবং আউটলেট ত্যাগের পূর্বে স্বয়ংক্রিয় ভাউচার এবং SMS এর মাধ্যমে হিসাবের ব্যালেন্স নিশ্চিত করুন।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">৭.</span>
                                <p class="bn-text-justify">আপনার দ্বারা সংগঠিত লেনদেন ব্যতীত অন্য কোন লেনদেনের SMS পেলে তৎক্ষনাৎ ব্যাংক কর্তৃপক্ষকে অবহিত করুন।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">৮.</span>
                                <p class="bn-text-justify">চেক বইয়ের নিরাপত্তা নিশ্চিত করুন।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">৯.</span>
                                <p class="bn-text-justify">ব্যাংক থেকে প্রদত্ত প্রতি মাসের অ্যাকাউন্ট ব্যালেন্সের SMS দেখুন এবং কোন অভিযোগ থাকলে ৭ (সাত) দিনের মধ্যে ব্যাংকে যোগাযোগ করুন।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">১০.</span>
                                <p class="bn-text-justify">এজেন্ট আউটলেটের অভ্যন্তরে কিংবা বাইরে ব্যাংকিং চ্যানেল এবং নিয়ম বহির্ভূত কোন লেনদেন করলে তার দায়ভার কোন অবস্থাতেই ব্যাংক বহন করবে না।</p>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-bold">১১.</span>
                                <p class="bn-text-justify">ব্যাংক এশিয়ার সেবা সংক্রান্ত আপনার যে কোন প্রয়োজনে যোগাযোগ করুন -১৬২০৫ নম্বরে।</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <table class="awareness-table text-black">
                            <tr>
                                <td class="label-cell">গ্রাহকের নাম (বাংলা)</td>
                                <td><?php echo e($acCreation->applicant_name_bn); ?></td>
                                <td rowspan="4" class="text-center align-middle" style="width: 35%;">
                                    <div class="flex flex-col items-center justify-center h-28">
                                        <?php if($acCreation->applicant_signature_path): ?>
                                            <img src="<?php echo e(str_replace(['http:', 'https:'], '', asset('storage/' . $acCreation->applicant_signature_path))); ?>" alt="Signature" class="max-h-16 object-contain mb-2">
                                        <?php else: ?>
                                            <div class="w-24 h-6 border-b border-dashed border-slate-400 mb-2"></div>
                                        <?php endif; ?>
                                        <div class="text-xs font-bold">গ্রাহকের স্বাক্ষর</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">কাস্টমার আইডি</td>
                                <td class="font-mono"><?php echo e($acCreation->customer_id ?? '---'); ?></td>
                            </tr>
                            <tr>
                                <td class="label-cell">মোবাইল নম্বর</td>
                                <td class="font-mono"><?php echo e($acCreation->mobile_number); ?></td>
                            </tr>
                            <tr>
                                <td class="label-cell">হিসাব নম্বর (যদি থাকে)</td>
                                <td class="font-mono"><?php echo e($acCreation->account_number ?? '---'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/services/bank-asia/ac-creations/show.blade.php ENDPATH**/ ?>