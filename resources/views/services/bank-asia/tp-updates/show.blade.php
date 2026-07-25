<x-app-layout title="TP Update Print">
    @php
        $hasUndertaking = !is_null($tpUpdate->animal_quantity) || !is_null($tpUpdate->total_amount);
        $expectedPages = $hasUndertaking ? 2 : 1;
    @endphp
    <style>
        @media print {
            /* Hide the application shell elements completely */
            aside,
            header,
            .no-print,
            .btn,
            /* Hide flash messages (like "TP Update created successfully") */
            main>section>div.rounded-lg {
                display: none !important;
            }

            /* Remove the grid layout that holds the sidebar space */
            .lg\:grid {
                display: block !important;
            }

            /* Remove padding from the main content area */
            section {
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Ensure the body is white and full width */
            body {
                background: white !important;
                color: black !important;
                margin: 0;
                padding: 0;
            }

            .page-break {
                page-break-before: always;
            }

            /* Setting margin to 0 hides the default browser header/footer (date, URL, etc.) */
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

            .print-doc, .pdf-overlay-page {
                width: 210mm !important;
                height: 297mm !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
                page-break-after: always !important;
                break-after: page !important;
                box-sizing: border-box;
            }

            .print-doc {
                padding: 20mm 15mm !important;
            }

            .pdf-overlay-page {
                padding: 0 !important; /* PDF overlays should not have page padding */
                position: relative !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-doc:last-child, .pdf-overlay-page:last-child {
                page-break-after: avoid !important;
                break-after: avoid !important;
            }
        }

        /* Screen view preview styling */
        .print-preview-container {
            max-width: 210mm;
            margin: 0 auto;
        }

        .print-doc {
            font-family: 'SolaimanLipi', 'Kalpurush', 'Siyam Rupali', Arial, sans-serif;
            color: #000;
            max-width: 210mm;
            /* A4 width */
            margin: 0 auto 24px auto;
            background: #fff;
            padding: 25mm 20mm;
            box-sizing: border-box;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            position: relative;
        }

        /* PDF Scanned Background Overlay View styling */
        .pdf-overlay-page {
            position: relative;
            width: 210mm;
            height: 297mm;
            margin: 0 auto 24px auto;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background-color: #fff;
            color: #000;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            box-sizing: border-box;
            overflow: hidden;
        }

        .pdf-overlay-page.tp-form {
            background-image: url("{{ str_replace(['http:', 'https:'], '', asset('bank-asia/tp_update.jpeg')) }}");
        }

        /* Absolutely positioned overlay labels */
        .overlay-field {
            position: absolute;
            font-family: 'SolaimanLipi', 'Kalpurush', 'Siyam Rupali', Arial, sans-serif;
            font-size: 13.5px;
            font-weight: bold;
            color: #000;
            pointer-events: none;
            white-space: nowrap;
        }

        .overlay-field.textarea-field {
            white-space: normal;
            line-height: 1.4;
        }

        .print-doc p {
            line-height: 1.4;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .bengali-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .bengali-table th,
        .bengali-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: left;
            font-size: 12px;
        }

        .bengali-table th {
            font-weight: bold;
        }

        .checkbox-square {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            text-align: center;
            line-height: 12px;
            font-size: 12px;
            vertical-align: middle;
            margin-right: 4px;
        }

        .dotted-line {
            display: inline-block;
            border-bottom: 1px dashed #000;
            min-width: 50px;
        }

        .flex-dotted-row {
            display: flex;
            align-items: flex-end;
            margin-bottom: 5px;
        }

        .flex-dotted-row .label {
            margin-right: 5px;
            white-space: nowrap;
            font-size: 12px;
        }

        .flex-dotted-row .dots {
            flex-grow: 1;
            border-bottom: 1px dashed #000;
            height: 1.1em;
            font-size: 12px;
        }

        .signature-box {
            border: 1px solid #000;
            padding: 8px;
        }

        /* Enlarged Cropper.js handles for easy touch selection */
        .cropper-point {
            background-color: #14b8a6 !important; /* Matches teal-500 theme */
            opacity: 0.9 !important;
        }
        
        .cropper-point.point-se,
        .cropper-point.point-sw,
        .cropper-point.point-nw,
        .cropper-point.point-ne {
            width: 32px !important;
            height: 32px !important;
            border-radius: 4px;
        }

        .cropper-point.point-se {
            right: -16px !important;
            bottom: -16px !important;
        }
        .cropper-point.point-sw {
            left: -16px !important;
            bottom: -16px !important;
        }
        .cropper-point.point-nw {
            left: -16px !important;
            top: -16px !important;
        }
        .cropper-point.point-ne {
            right: -16px !important;
            top: -16px !important;
        }

        /* Hide edge points on mobile to avoid clutter */
        @media (max-width: 640px) {
            .cropper-point.point-n,
            .cropper-point.point-s,
            .cropper-point.point-e,
            .cropper-point.point-w {
                display: none !important;
            }
        }
    </style>

    <div x-data="tpDocumentUpload({{ $expectedPages }})">
        <div class="mb-6 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4 no-print">
            <div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
                <a href="{{ route('bank-asia.tp-updates.index') }}" class="btn btn-muted flex items-center gap-2 shrink-0">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Back to List
                </a>
                
                {{-- Mode Switcher tabs --}}
                <div class="inline-flex rounded-lg p-1 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 max-w-full overflow-x-auto hide-scrollbar">
                    <button @click="activeTab = 'pdf'" :class="activeTab === 'pdf' ? 'bg-white dark:bg-slate-900 shadow-sm text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-600 dark:text-slate-400'" class="px-3 sm:px-4 py-1.5 text-xs rounded-md transition duration-200 whitespace-nowrap shrink-0">
                        পিডিএফ ফিল্ড ভিউ (PDF Overlay)
                    </button>
                    <button @click="activeTab = 'digital'" :class="activeTab === 'digital' ? 'bg-white dark:bg-slate-900 shadow-sm text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-600 dark:text-slate-400'" class="px-3 sm:px-4 py-1.5 text-xs rounded-md transition duration-200 whitespace-nowrap shrink-0">
                        ডিজিটাল প্রিন্ট ভিউ (HTML Design)
                    </button>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full xl:w-auto">
                <a href="{{ route('bank-asia.tp-updates.edit', $tpUpdate) }}" class="btn btn-muted flex items-center gap-2 shrink-0">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
                <button onclick="window.print()" class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white border-transparent flex items-center gap-2 shrink-0">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg>
                    Print
                </button>
                <button @click="$refs.fileInput.click()" class="btn btn-primary bg-teal-600 hover:bg-teal-700 text-white border-transparent flex items-center gap-2 shrink-0">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    Upload Doc
                </button>
                <input type="file" x-ref="fileInput" @change="handleFile" accept="image/*" class="hidden" capture="environment">
            </div>
        </div>

        <!-- Cropper Modal -->
        <template x-teleport="body">
            <div x-show="isCropping" class="fixed inset-0 z-[100] bg-slate-900/95 flex flex-col no-print overflow-hidden h-[100dvh] w-screen" style="display: none;" @keydown.escape.window="closeModal()">
                <!-- Strict height container for cropper to prevent flex blowout -->
                <div class="relative flex-1 w-full overflow-hidden bg-black/50">
                    <div class="absolute inset-2 sm:inset-4 flex items-center justify-center">
                        <img x-ref="image" class="block max-w-full max-h-full">
                    </div>
                </div>
                <!-- Bottom Action Bar -->
                <div class="relative bg-slate-800 p-3 sm:p-4 shrink-0 shadow-[0_-10px_40px_rgba(0,0,0,0.3)] flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 border-t border-slate-700/80 z-10 w-full" style="padding-bottom: calc(12px + env(safe-area-inset-bottom));">
                    <!-- Eraser Settings Snackbar -->
                    <div x-show="isErasing" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-4"
                         class="absolute bottom-[calc(100%+12px)] right-3 sm:right-4 w-64 bg-slate-800/95 backdrop-blur-md rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] border border-slate-600 p-4 z-20" style="display: none;">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-slate-200 text-sm font-semibold flex items-center gap-2">
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg>
                                Eraser Size
                            </h3>
                            <button @click="toggleEraseMode()" class="text-slate-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs font-medium text-slate-300 mb-1.5">
                                <span>Brush Size</span>
                                <span x-text="eraserSize + 'px'"></span>
                            </div>
                            <input type="range" x-model="eraserSize" min="5" max="100" class="w-full h-1.5 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-pink-500">
                        </div>
                    </div>

                    <!-- Adjustments Snackbar / Bottom Sheet -->
                    <div x-show="showAdjustments" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-4"
                         class="absolute bottom-[calc(100%+12px)] left-3 right-3 sm:left-auto sm:right-4 sm:w-80 bg-slate-800/95 backdrop-blur-md rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] border border-slate-600 p-4 z-20" style="display: none;">
                        
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-slate-200 text-sm font-semibold">Custom Enhancements</h3>
                            <button @click="showAdjustments = false" class="text-slate-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-xs font-medium text-slate-300 mb-1.5">
                                    <span>Brightness</span>
                                    <span x-text="brightness + '%'"></span>
                                </div>
                                <input type="range" x-model="brightness" min="50" max="200" @input="setCustomFilter()" class="w-full h-1.5 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-teal-500">
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-medium text-slate-300 mb-1.5">
                                    <span>Contrast</span>
                                    <span x-text="contrast + '%'"></span>
                                </div>
                                <input type="range" x-model="contrast" min="50" max="200" @input="setCustomFilter()" class="w-full h-1.5 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-teal-500">
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-medium text-slate-300 mb-1.5">
                                    <span>Saturation</span>
                                    <span x-text="saturation + '%'"></span>
                                </div>
                                <input type="range" x-model="saturation" min="0" max="200" @input="setCustomFilter()" class="w-full h-1.5 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-teal-500">
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-medium text-slate-300 mb-1.5">
                                    <span>Grayscale</span>
                                    <span x-text="grayscale + '%'"></span>
                                </div>
                                <input type="range" x-model="grayscale" min="0" max="100" @input="setCustomFilter()" class="w-full h-1.5 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-teal-500">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between w-full sm:w-auto shrink-0 order-1 sm:order-none gap-2">
                        <div class="flex items-center gap-1 sm:gap-2">
                            <label class="hidden sm:block text-xs sm:text-sm font-medium text-slate-300 whitespace-nowrap">Format:</label>
                            <div class="relative w-full sm:w-28">
                                <select x-model="exportFormat" class="appearance-none block w-full rounded-lg border-slate-600 bg-slate-700/50 text-white text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 py-1.5 sm:py-2 pl-3 pr-8">
                                    <option value="pdf">PDF</option>
                                    <option value="jpg">JPG</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-2">
                            <label class="hidden sm:block text-xs sm:text-sm font-medium text-slate-300 whitespace-nowrap">Filter:</label>
                            <div class="relative w-full sm:w-36">
                                <select x-model="imageFilter" @change="applyPresetFilter()" class="appearance-none block w-full rounded-lg border-slate-600 bg-slate-700/50 text-white text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 py-1.5 sm:py-2 pl-3 pr-8">
                                    <option value="none">Normal</option>
                                    <option value="document">B&W Document</option>
                                    <option value="enhance">Enhance Color</option>
                                    <option value="custom">Custom</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <button @click="showAdjustments = !showAdjustments; if(showAdjustments) { isErasing = false; if(pendingRotation) { cropper.rotateTo(pendingRotation); pendingRotation = 0; } }" class="p-1.5 sm:p-2 bg-slate-700 text-white border border-slate-600 rounded-lg hover:bg-slate-600 transition-colors" title="Manual Adjustments" :class="showAdjustments ? 'bg-teal-600 border-teal-500' : ''">
                                <svg class="size-4 sm:size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10M18 20V4M6 20v-4M6 12V4M12 6V4M18 16v-4"/></svg>
                            </button>
                            <button @click="toggleEraseMode()" class="p-1.5 sm:p-2 bg-slate-700 text-white border border-slate-600 rounded-lg hover:bg-slate-600 transition-colors" title="Eraser Tool" :class="isErasing ? 'bg-pink-600 border-pink-500' : ''">
                                <svg class="size-4 sm:size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-between sm:justify-end order-2 sm:order-none">
                        <div class="flex items-center gap-2">
                            <button @click="closeModal()" class="btn px-3 py-1.5 sm:py-2 bg-slate-700 text-white border-slate-600 hover:bg-slate-600 text-xs sm:text-sm font-medium rounded-lg">
                                Cancel
                            </button>
                            <button @click="rotateImage()" class="btn px-3 py-1.5 sm:py-2 bg-slate-700 text-white border-slate-600 hover:bg-slate-600 shrink-0 rounded-lg" title="Rotate 90°">
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.92-10.44l5.67-5.67"/></svg>
                            </button>
                        </div>
                        
                        <template x-if="croppedPages.length + 1 < expectedPages">
                            <button @click="nextPage()" class="btn px-4 py-1.5 sm:py-2 bg-blue-600 text-white border-transparent hover:bg-blue-700 flex items-center gap-2 text-xs sm:text-sm font-bold rounded-lg shadow-md shadow-blue-900/20">
                                Next Page
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </button>
                        </template>
                        <template x-if="croppedPages.length + 1 === expectedPages">
                            <button @click="shareEmail()" class="btn px-4 py-1.5 sm:py-2 bg-teal-600 text-white border-transparent hover:bg-teal-700 flex items-center gap-2 text-xs sm:text-sm font-bold rounded-lg shadow-md shadow-teal-900/20">
                                <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                Share
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    <div id="print-area" class="overflow-x-auto w-full max-w-full pb-4">
        @php
            $hasRegular = $tpUpdate->regular_daily_tx_count || $tpUpdate->regular_monthly_tx_count ||
                $tpUpdate->regular_withdrawal_daily_count || $tpUpdate->regular_withdrawal_monthly_count ||
                $tpUpdate->regular_transfer_daily_count || $tpUpdate->regular_transfer_monthly_count;
            $hasOneTime = $tpUpdate->one_time_cash_deposit_count || $tpUpdate->one_time_cash_withdrawal_count || $tpUpdate->one_time_transfer_count ||
                $tpUpdate->one_time_cash_deposit_monthly_count || $tpUpdate->one_time_cash_withdrawal_monthly_count || $tpUpdate->one_time_transfer_monthly_count;
        @endphp
        {{-- PAGE 1: Undertaking --}}
        @if(!is_null($tpUpdate->animal_quantity) || !is_null($tpUpdate->total_amount))
        <div class="print-doc">
            <h1 class="text-2xl font-bold text-center mb-6"
                style="text-decoration: underline; text-underline-offset: 6px;">অঙ্গীকারনামা</h1>

            <p class="text-justify mb-5" style="font-size: 14px; line-height: 1.6;">
                আমি <span class="font-bold">{{ $tpUpdate->account_name }}</span>, ব্যাংক হিসাব নং <span
                    class="font-bold">{{ $tpUpdate->account_number }}</span> ব্যাংক এশিয়া এজেন্ট ব্যাংকিং ডিভিশনের
                ডুমুরিয়া ডিপিও আউটলেটের একজন গ্রাহক। আমি আমার বাড়িতে পারিবারিকভাবে নিয়মিত কয়েকটি গরু লালন-পালন করি। গরু
                ব্যবসায়িকভাবে পালন না করার কারণে আমার কোন ট্রেড লাইসেন্স নেই।
                <span class="font-bold">{{ date('d/m/Y', strtotime($tpUpdate->date)) }}</span> ইং তারিখে আমি আমার পালন
                কৃত (<span
                    class="font-bold">{{ $tpUpdate->animal_quantity ?? '' }}</span>) টি
                গরু বিক্রি করে <span class="font-bold">{{ number_format($tpUpdate->total_amount ?? 0) }}/=</span>
                টাকা পাই। উক্ত টাকা ব্যাংক এশিয়া এজেন্ট ব্যাংকিং ডিভিশনে ডুমুরিয়া ডিপিও আউটলেটে আমার উক্ত ব্যাংক হিসাবে
                রাখতে চাই।
            </p>

            <p class="text-justify mb-5" style="font-size: 14px; line-height: 1.6;">
                আমি এই মর্মে প্রত্যয়ন করছি যে, উক্ত টাকা আমার বৈধ আয় এবং আমি কোন রাষ্ট্রবিরোধী ও সন্ত্রাসী কর্মকান্ডে
                লিপ্ত নই।
            </p>

            <p class="text-justify mb-10" style="font-size: 14px; line-height: 1.6;">
                অতএব, জনাবের নিকট আবেদন উল্লেখিত টাকা জমা রাখার লক্ষ্যে আমার নতুন লেনদেন মাত্রা অনুমোদন দিতে মর্জি হয়
            </p>

            <div class="flex justify-end mb-10 mt-20">
                <div class="text-center" style="width: 250px;">
                    <div style="height: 80px;"></div>
                    <div style="border-bottom: 1px dashed #000; width: 100%; margin-bottom: 6px;"></div>
                    <p style="margin: 0; font-size: 14px;">গ্রাহকের নাম ও স্বাক্ষর</p>
                    <p style="margin: 0; font-size: 14px;">তারিখ: {{ date('d/m/Y', strtotime($tpUpdate->date)) }}</p>
                </div>
            </div>

            <div style="border-top: 1px dashed #000; margin: 20px 0;"></div>

            <h2 class="text-xl font-bold text-center mb-5">এজেন্ট/ সিএসও-এর অংশ</h2>

            <p class="text-justify mb-8" style="font-size: 14px; line-height: 1.6;">
                আমি নিম্ন স্বাক্ষরকারী এই মর্মে প্রত্যয়ন করছি যে, উক্ত গ্রাহকের টাকা সমূহ বৈধভাবে অর্জিত এবং আমার
                জানামতে তিনি কোন রাষ্ট্রবিরোধী কাজ ও সন্ত্রাসী কর্মকান্ডে লিপ্ত নন। আমি তাকে ব্যক্তিগত ভাবে চিনি ও উক্ত
                ব্যক্তির অর্থের উৎস যথাযথ ভাবে যাচাই করে নতুন লেনদেন মাত্রা অনুমতি দানের অনুরোধ করছি।
            </p>

            <div class="flex justify-end">
                <div style="width: 350px;">
                    <div class="flex-dotted-row mt-12">
                        <span class="label" style="font-size: 14px;">স্বাক্ষর:</span>
                        <div class="dots" style="height: 60px;"></div>
                    </div>
                    <div class="flex-dotted-row mt-3">
                        <span class="label" style="font-size: 14px;">নাম (এজেন্ট/সিএসও):</span>
                        <div class="dots text-center pb-1" style="font-size: 14px;">{{ $tpUpdate->agent_name }}</div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label" style="font-size: 14px;">পদবী:</span>
                        <div class="dots text-center pb-1" style="font-size: 14px;">{{ $tpUpdate->agent_designation }}
                        </div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label" style="font-size: 14px;">মোবাইল নং:</span>
                        <div class="dots text-center pb-1" style="font-size: 14px;">{{ $tpUpdate->agent_mobile }}</div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label" style="font-size: 14px;">আউটলেটের নাম ও ঠিকানা:</span>
                        <div class="dots text-center pb-1" style="font-size: 14px;">{{ $tpUpdate->outlet_name_address }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- PAGE 2: Application --}}
        <div class="print-digital-only" x-show="activeTab === 'digital'">
            <div class="print-doc {{ (!is_null($tpUpdate->animal_quantity) || !is_null($tpUpdate->total_amount)) ? 'page-break' : '' }}">
            <div class="flex justify-between items-start mb-2">
                <div style="line-height: 1.3;">
                    <p style="margin:0;">বরাবর</p>
                    <p style="margin:0;">হেড অফ এজেন্ট ব্যাংকিং ডিভিশন</p>
                    <p style="margin:0;">ব্যাংক এশিয়া পিএলসি</p>
                    <p style="margin:0;">৬৮, র‍্যাংগস টাওয়ার, পুরান পল্টন, ঢাকা- ১০০০।</p>
                </div>
                <div class="flex-dotted-row" style="width: 150px;">
                    <span class="label">তারিখ:</span>
                    <span class="dots text-center">{{ date('d / m / Y', strtotime($tpUpdate->date)) }}</span>
                </div>
            </div>

            <p class="font-bold mb-2" style="font-size: 14px;">বিষয়: ট্রানজেকশন প্রোফাইল আপডেট করার জন্য আবেদন।</p>

            <p class="mb-2 text-justify" style="line-height: 1.4;">জনাব,<br>বিনীত নিবেদন এই যে, ব্যাংক এশিয়া এজেন্ট
                ব্যাংকিং এ আমার/ আমাদের নিম্নে উল্লিখিত একাউন্টে নিয়মিত/ একবার লেনদেন করার জন্য ট্রানজেকশন প্রোফাইল
                আপডেট করা প্রয়োজন। বিস্তারিত নিম্নে প্রদান করা হল:</p>

            <table class="bengali-table">
                <tr>
                    <td style="width: 120px; padding: 2px 5px;">হিসাব নম্বর:</td>
                    <td class="font-bold" style="font-size: 14px; letter-spacing: 2px; padding: 2px 5px;">
                        {{ $tpUpdate->account_number }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 2px 5px;">হিসাব নাম:</td>
                    <td class="font-bold" style="font-size: 14px; padding: 2px 5px;">{{ $tpUpdate->account_name }}</td>
                </tr>
            </table>

            <div class="flex items-center gap-4 mb-2 text-xs mt-2">
                <span style="min-width: 80px;">হিসাবের ধরন:</span>
                <label class="flex items-center"><span
                        class="checkbox-square">{!! $tpUpdate->account_type == 'Current Account' ? '&#10003;' : '&nbsp;' !!}</span>
                    কারেন্ট একাউন্ট</label>
                <label class="flex items-center"><span
                        class="checkbox-square">{!! $tpUpdate->account_type == 'Savings Account' ? '&#10003;' : '&nbsp;' !!}</span>
                    সেভিংস একাউন্ট</label>
                <label class="flex items-center"><span
                        class="checkbox-square">{!! $tpUpdate->account_type == 'SND Account' ? '&#10003;' : '&nbsp;' !!}</span>
                    এস.এন.ডি একাউন্ট</label>
                <label class="flex items-center"><span
                        class="checkbox-square">{!! $tpUpdate->account_type == 'Other' ? '&#10003;' : '&nbsp;' !!}</span>
                    অন্যান্য</label>
            </div>

            @php
                $hasRegular = $tpUpdate->regular_daily_tx_count || $tpUpdate->regular_monthly_tx_count ||
                    $tpUpdate->regular_withdrawal_daily_count || $tpUpdate->regular_withdrawal_monthly_count ||
                    $tpUpdate->regular_transfer_daily_count || $tpUpdate->regular_transfer_monthly_count;
                $hasOneTime = $tpUpdate->one_time_cash_deposit_count || $tpUpdate->one_time_cash_withdrawal_count || $tpUpdate->one_time_transfer_count ||
                    $tpUpdate->one_time_cash_deposit_monthly_count || $tpUpdate->one_time_cash_withdrawal_monthly_count || $tpUpdate->one_time_transfer_monthly_count;
            @endphp

            <div class="mb-1 mt-2 text-xs">
                <span class="checkbox-square">{!! $hasRegular ? '&#10003;' : '&nbsp;' !!}</span> নিয়মিত লেনদেনের
                ক্ষেত্রে:
            </div>
            <table class="bengali-table">
                <tr>
                    <th rowspan="2" class="text-center" style="width: 25%;">বিবরণ</th>
                    <th colspan="2" class="text-center">দৈনিক লেনদেন</th>
                    <th colspan="2" class="text-center">মাসিক লেনদেন</th>
                </tr>
                <tr>
                    <th class="text-center" style="width: 18.75%;">লেনদেনের সংখ্যা</th>
                    <th class="text-center" style="width: 18.75%;">পরিমাণ</th>
                    <th class="text-center" style="width: 18.75%;">লেনদেনের সংখ্যা</th>
                    <th class="text-center" style="width: 18.75%;">পরিমাণ</th>
                </tr>
                <tr>
                    <td>নগদ জমা</td>
                    <td class="text-center font-bold">{{ $tpUpdate->regular_daily_tx_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->regular_daily_tx_amount) ? number_format($tpUpdate->regular_daily_tx_amount) : '' }}</td>
                    <td class="text-center font-bold">{{ $tpUpdate->regular_monthly_tx_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->regular_monthly_tx_amount) ? number_format($tpUpdate->regular_monthly_tx_amount) : '' }}</td>
                </tr>
                <tr>
                    <td>নগদ উত্তোলন</td>
                    <td class="text-center font-bold">{{ $tpUpdate->regular_withdrawal_daily_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->regular_withdrawal_daily_amount) ? number_format($tpUpdate->regular_withdrawal_daily_amount) : '' }}</td>
                    <td class="text-center font-bold">{{ $tpUpdate->regular_withdrawal_monthly_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->regular_withdrawal_monthly_amount) ? number_format($tpUpdate->regular_withdrawal_monthly_amount) : '' }}</td>
                </tr>
                <tr>
                    <td>স্থানান্তর লেনদেন</td>
                    <td class="text-center font-bold">{{ $tpUpdate->regular_transfer_daily_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->regular_transfer_daily_amount) ? number_format($tpUpdate->regular_transfer_daily_amount) : '' }}</td>
                    <td class="text-center font-bold">{{ $tpUpdate->regular_transfer_monthly_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->regular_transfer_monthly_amount) ? number_format($tpUpdate->regular_transfer_monthly_amount) : '' }}</td>
                </tr>
            </table>

            <div class="mb-1 mt-2 text-xs">
                <span class="checkbox-square">{!! $hasOneTime ? '&#10003;' : '&nbsp;' !!}</span> একবার লেনদেনের
                ক্ষেত্রে:
            </div>
            <table class="bengali-table">
                <tr>
                    <th rowspan="2" class="text-center" style="width: 25%;">বিবরণ</th>
                    <th colspan="2" class="text-center">দৈনিক লেনদেন</th>
                    <th colspan="2" class="text-center">মাসিক লেনদেন</th>
                </tr>
                <tr>
                    <th class="text-center" style="width: 18.75%;">লেনদেনের সংখ্যা</th>
                    <th class="text-center" style="width: 18.75%;">পরিমাণ</th>
                    <th class="text-center" style="width: 18.75%;">লেনদেনের সংখ্যা</th>
                    <th class="text-center" style="width: 18.75%;">পরিমাণ</th>
                </tr>
                <tr>
                    <td>নগদ জমা</td>
                    <td class="text-center font-bold">{{ $tpUpdate->one_time_cash_deposit_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->one_time_cash_deposit_amount) ? number_format($tpUpdate->one_time_cash_deposit_amount) : '' }}</td>
                    <td class="text-center font-bold">{{ $tpUpdate->one_time_cash_deposit_monthly_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->one_time_cash_deposit_monthly_amount) ? number_format($tpUpdate->one_time_cash_deposit_monthly_amount) : '' }}</td>
                </tr>
                <tr>
                    <td>নগদ উত্তোলন</td>
                    <td class="text-center font-bold">{{ $tpUpdate->one_time_cash_withdrawal_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->one_time_cash_withdrawal_amount) ? number_format($tpUpdate->one_time_cash_withdrawal_amount) : '' }}</td>
                    <td class="text-center font-bold">{{ $tpUpdate->one_time_cash_withdrawal_monthly_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->one_time_cash_withdrawal_monthly_amount) ? number_format($tpUpdate->one_time_cash_withdrawal_monthly_amount) : '' }}</td>
                </tr>
                <tr>
                    <td>স্থানান্তর লেনদেন</td>
                    <td class="text-center font-bold">{{ $tpUpdate->one_time_transfer_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->one_time_transfer_amount) ? number_format($tpUpdate->one_time_transfer_amount) : '' }}</td>
                    <td class="text-center font-bold">{{ $tpUpdate->one_time_transfer_monthly_count }}</td>
                    <td class="text-center font-bold">{{ !is_null($tpUpdate->one_time_transfer_monthly_amount) ? number_format($tpUpdate->one_time_transfer_monthly_amount) : '' }}</td>
                </tr>
            </table>

            <div class="mb-2 mt-2">
                <p style="margin-bottom: 2px;">লেনদেনের তহবিলের উৎস:</p>
                <div
                    style="border: 1px solid #000; height: 26px; width: 100%; padding: 2px 8px; box-sizing: border-box; font-size: 12px; line-height: 20px;">
                    {{ $tpUpdate->source_of_funds }}
                </div>
            </div>

            <p class="text-justify mb-2" style="font-size: 12px; line-height: 1.3;">
                আমি/আমরা নিম্নস্বাক্ষরকারী নিশ্চিত করছি যে উল্লিখিত ট্রানজেকশন প্রোফাইলটি আমার/সংস্থার জন্য স্বাভাবিক।
                আমি/আমরা আরও নিশ্চিত করছি যে ট্রানজেকশন প্রোফাইল যখন প্রয়োজন হবে তখন সংশোধন/আপডেট করা হবে।
            </p>

            <div class="signature-box mb-2">
                <p class="mb-2 text-sm">বিনীত নিবেদক,</p>
                <div style="display: flex; justify-content: space-between; gap: 10px;">
                    <div style="width: 32%;">
                        <p class="mb-1 text-xs">(১) স্বাক্ষর ও সীল:</p>
                        <div class="flex-dotted-row">
                            <span class="label">গ্রাহকের নাম:</span>
                            <div class="dots text-center">{{ $tpUpdate->account_name }}</div>
                        </div>
                        <div class="flex-dotted-row">
                            <span class="label">ফোন/মোবাইল নম্বর:</span>
                            <div class="dots text-center">{{ $tpUpdate->client_mobile }}</div>
                        </div>
                    </div>
                    <div style="width: 32%;">
                        <p class="mb-1 text-xs">(২) স্বাক্ষর ও সীল:</p>
                        <div class="flex-dotted-row">
                            <span class="label">গ্রাহকের নাম:</span>
                            <div class="dots"></div>
                        </div>
                        <div class="flex-dotted-row">
                            <span class="label">ফোন/মোবাইল নম্বর:</span>
                            <div class="dots"></div>
                        </div>
                    </div>
                    <div style="width: 32%;">
                        <p class="mb-1 text-xs">(৩) স্বাক্ষর ও সীল:</p>
                        <div class="flex-dotted-row">
                            <span class="label">গ্রাহকের নাম:</span>
                            <div class="dots"></div>
                        </div>
                        <div class="flex-dotted-row">
                            <span class="label">ফোন/মোবাইল নম্বর:</span>
                            <div class="dots"></div>
                        </div>
                    </div>
                </div>
                <p class="text-[10px] mt-2 text-center">ব্যক্তিক একাউন্ট না হলে সেক্ষেত্রে সীল প্রদান করুন।</p>
            </div>

            <div style="display: flex; justify-content: space-between; gap: 10px;">
                <div class="signature-box" style="width: 49%;">
                    <p class="font-bold mb-3 text-sm">স্বীকৃতি প্রদানকারী এজেন্ট/ সিএসও,</p>
                    <div class="flex-dotted-row mt-4">
                        <span class="label">স্বাক্ষর:</span>
                        <div class="dots" style="height: 25px;"></div>
                    </div>
                    <div class="flex-dotted-row mt-2">
                        <span class="label">এজেন্ট/সিএসওর নাম:</span>
                        <div class="dots text-center">{{ $tpUpdate->agent_name }}</div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label">তারিখ:</span>
                        <div class="dots text-center">{{ date('d/m/Y', strtotime($tpUpdate->date)) }}</div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label">আউটলেটের নাম:</span>
                        <div class="dots text-center">{{ $tpUpdate->outlet_name_address }}</div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label">ফোন/মোবাইল নম্বর:</span>
                        <div class="dots text-center">{{ $tpUpdate->agent_mobile }}</div>
                    </div>
                </div>
                <div class="signature-box" style="width: 49%;">
                    <p class="font-bold mb-3 text-sm">যাচাইকারী ব্যাংক কর্মকর্তা,</p>
                    <div class="flex-dotted-row mt-2">
                        <span class="label">স্বাক্ষর:</span>
                        <div class="dots"></div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label">অফিসারের নাম:</span>
                        <div class="dots"></div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label">পদবী:</span>
                        <div class="dots"></div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label">তারিখ:</span>
                        <div class="dots"></div>
                    </div>
                    <div class="flex-dotted-row">
                        <span class="label">ফোন/মোবাইল নম্বর:</span>
                        <div class="dots"></div>
                    </div>
                </div>
            </div>

            <p class="font-bold mt-2 text-center" style="font-size: 11px;">&#x2022; নগদ জমার ক্ষেত্রে লেনদেনের তহবিলের
                উৎস উল্লেখ করা আবশ্যক।</p>
        </div>
        </div>

        <div class="print-pdf-only" x-show="activeTab === 'pdf'">
            <div class="pdf-overlay-page tp-form {{ (!is_null($tpUpdate->animal_quantity) || !is_null($tpUpdate->total_amount)) ? 'page-break' : '' }}">
                {{-- Date --}}
                <div class="overlay-field font-bold font-mono" style="top: 7.9%; left: 78.5%;">
                    {{ date('d', strtotime($tpUpdate->date)) }}<span style="margin: 0 17px;">{{ date('m', strtotime($tpUpdate->date)) }}</span><span style="margin: 0px;">{{ date('Y', strtotime($tpUpdate->date)) }}</span>
                </div>

                {{-- Account Number --}}
                <div class="overlay-field font-mono font-bold" style="top: 22.6%; left: 28.0%; font-size: 15px; letter-spacing: 2px;">
                    {{ $tpUpdate->account_number }}
                </div>

                {{-- Account Name --}}
                <div class="overlay-field font-bold" style="top: 25.3%; left: 28.0%; font-size: 14px;">
                    {{ $tpUpdate->account_name }}
                </div>

                {{-- Account Type Checkboxes --}}
                @if($tpUpdate->account_type == 'Current Account')
                    <div class="overlay-field font-bold text-lg" style="top:27.1%; left: 27.2%;">✔</div>
                @endif
                @if($tpUpdate->account_type == 'Savings Account')
                    <div class="overlay-field font-bold text-lg" style="top: 27.1%; left: 43.8%;">✔</div>
                @endif
                @if($tpUpdate->account_type == 'SND Account')
                    <div class="overlay-field font-bold text-lg" style="top: 27.1%; left: 62.3%;">✔</div>
                @endif
                @if($tpUpdate->account_type == 'Other')
                    <div class="overlay-field font-bold text-lg" style="top: 27.1%; left: 82.7%;">✔</div>
                @endif

                {{-- Regular Tx Checkbox --}}
                @if($hasRegular)
                    <div class="overlay-field font-bold text-lg" style="top: 29.4%; left: 9.9%;">✔</div>
                @endif

                {{-- Regular Tx Table --}}
                <div class="overlay-field font-bold font-mono" style="top: 34.5%; left: 35.0%;">{{ $tpUpdate->regular_daily_tx_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 34.5%; left: 47.5%;">{{ !is_null($tpUpdate->regular_daily_tx_amount) ? number_format($tpUpdate->regular_daily_tx_amount) : '' }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 34.5%; left: 66.0%;">{{ $tpUpdate->regular_monthly_tx_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 34.5%; left: 79.5%;">{{ !is_null($tpUpdate->regular_monthly_tx_amount) ? number_format($tpUpdate->regular_monthly_tx_amount) : '' }}</div>

                <div class="overlay-field font-bold font-mono" style="top: 36.4%; left: 35.0%;">{{ $tpUpdate->regular_withdrawal_daily_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 36.4%; left: 47.5%;">{{ !is_null($tpUpdate->regular_withdrawal_daily_amount) ? number_format($tpUpdate->regular_withdrawal_daily_amount) : '' }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 36.4%; left: 66.0%;">{{ $tpUpdate->regular_withdrawal_monthly_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 36.4%; left: 79.5%;">{{ !is_null($tpUpdate->regular_withdrawal_monthly_amount) ? number_format($tpUpdate->regular_withdrawal_monthly_amount) : '' }}</div>

                <div class="overlay-field font-bold font-mono" style="top: 38.2%; left: 35.0%;">{{ $tpUpdate->regular_transfer_daily_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 38.2%; left: 47.5%;">{{ !is_null($tpUpdate->regular_transfer_daily_amount) ? number_format($tpUpdate->regular_transfer_daily_amount) : '' }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 38.2%; left: 66.0%;">{{ $tpUpdate->regular_transfer_monthly_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 38.2%; left: 79.5%;">{{ !is_null($tpUpdate->regular_transfer_monthly_amount) ? number_format($tpUpdate->regular_transfer_monthly_amount) : '' }}</div>

                {{-- One-Time Tx Checkbox --}}
                @if($hasOneTime)
                    <div class="overlay-field font-bold text-lg" style="top: 40.6%; left: 9.9%;">✔</div>
                @endif

                {{-- One-Time Tx Table --}}
                <div class="overlay-field font-bold font-mono" style="top: 45.8%; left: 35.0%;">{{ $tpUpdate->one_time_cash_deposit_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 45.8%; left: 47.5%;">{{ !is_null($tpUpdate->one_time_cash_deposit_amount) ? number_format($tpUpdate->one_time_cash_deposit_amount) : '' }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 45.8%; left: 66.0%;">{{ $tpUpdate->one_time_cash_deposit_monthly_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 45.8%; left: 79.5%;">{{ !is_null($tpUpdate->one_time_cash_deposit_monthly_amount) ? number_format($tpUpdate->one_time_cash_deposit_monthly_amount) : '' }}</div>

                <div class="overlay-field font-bold font-mono" style="top: 47.7%; left: 35.0%;">{{ $tpUpdate->one_time_cash_withdrawal_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 47.7%; left: 47.5%;">{{ !is_null($tpUpdate->one_time_cash_withdrawal_amount) ? number_format($tpUpdate->one_time_cash_withdrawal_amount) : '' }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 47.7%; left: 66.0%;">{{ $tpUpdate->one_time_cash_withdrawal_monthly_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 47.7%; left: 79.5%;">{{ !is_null($tpUpdate->one_time_cash_withdrawal_monthly_amount) ? number_format($tpUpdate->one_time_cash_withdrawal_monthly_amount) : '' }}</div>

                <div class="overlay-field font-bold font-mono" style="top: 49.5%; left: 35.0%;">{{ $tpUpdate->one_time_transfer_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 49.5%; left: 47.5%;">{{ !is_null($tpUpdate->one_time_transfer_amount) ? number_format($tpUpdate->one_time_transfer_amount) : '' }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 49.5%; left: 66.0%;">{{ $tpUpdate->one_time_transfer_monthly_count }}</div>
                <div class="overlay-field font-bold font-mono" style="top: 49.5%; left: 79.5%;">{{ !is_null($tpUpdate->one_time_transfer_monthly_amount) ? number_format($tpUpdate->one_time_transfer_monthly_amount) : '' }}</div>

                {{-- Source of Funds --}}
                <div class="overlay-field font-bold" style="top: 52.4%; left: 31.5%; width: 41.5%; font-size: 13px;">
                    {{ $tpUpdate->source_of_funds }}
                </div>

                {{-- Client Info --}}
                <div class="overlay-field font-bold" style="top: 62.2%; left: 21.0%; font-size: 12px !important;">
                    {{ $tpUpdate->account_name }}
                </div>
                <div class="overlay-field font-bold font-mono" style="top: 64%; left: 25.0%; font-size: 12px;">
                    {{ $tpUpdate->client_mobile }}
                </div>

                {{-- Agent Details --}}
                <div class="overlay-field font-bold" style="top: 76.7%; left: 23.0%; font-size: 12.5px;">
                    {{ $tpUpdate->agent_name }}
                </div>
                <div class="overlay-field font-bold" style="top: 78.6%; left: 23.0%; font-size: 12.5px;">
                    {{ date('d / m / Y', strtotime($tpUpdate->date)) }}
                </div>
                <div class="overlay-field font-bold" style="top: 80.3%; left: 23.0%; font-size: 12.5px;">
                    {{ $tpUpdate->outlet_name_address }}
                </div>
                <div class="overlay-field font-bold font-mono" style="top: 82.4%; left: 23.0%; font-size: 12.5px;">
                    {{ $tpUpdate->agent_mobile }}
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Include Cropper.js & jsPDF -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tpDocumentUpload', (expectedPages = 1) => ({
                activeTab: 'pdf',
                isCropping: false,
                cropper: null,
                exportFormat: 'pdf',
                imageFilter: 'document',
                showAdjustments: false,
                isErasing: false,
                eraserSize: 20,
                drawCanvas: null,
                drawCtx: null,
                isDrawing: false,
                eraserEventsAttached: false,
                pendingCropperData: null,
                pendingRotation: 0,
                brightness: 110,
                contrast: 160,
                saturation: 100,
                grayscale: 100,
                expectedPages: expectedPages,
                croppedPages: [],
                
                toggleEraseMode() {
                    this.isErasing = !this.isErasing;
                    if (this.isErasing) {
                        this.showAdjustments = false;
                        this.cropper.setDragMode('none');
                        
                        const currentData = this.cropper.getImageData();
                        if (currentData.rotate !== 0) {
                            this.pendingRotation = currentData.rotate;
                            this.cropper.rotateTo(0);
                        }
                        
                        setTimeout(() => this.injectEraseLayer(), 100);
                    } else {
                        this.cropper.setDragMode('move');
                        const el = document.querySelector('.erase-layer');
                        if (el) el.style.display = 'none';
                        
                        if (this.pendingRotation !== 0) {
                            this.cropper.rotateTo(this.pendingRotation);
                            this.pendingRotation = 0;
                        }
                    }
                },

                injectEraseLayer() {
                    const canvasContainer = document.querySelector('.cropper-canvas');
                    if (!canvasContainer) return;
                    
                    let eraseLayer = document.querySelector('.erase-layer');
                    if (!eraseLayer) {
                        eraseLayer = document.createElement('canvas');
                        eraseLayer.className = 'erase-layer';
                        eraseLayer.style.width = '100%';
                        eraseLayer.style.height = '100%';
                        eraseLayer.style.position = 'absolute';
                        eraseLayer.style.top = '0';
                        eraseLayer.style.left = '0';
                        eraseLayer.style.pointerEvents = 'none';
                        eraseLayer.style.zIndex = '50';
                        canvasContainer.appendChild(eraseLayer);
                    }
                    eraseLayer.style.display = 'block';

                    const imageData = this.cropper.getImageData();
                    if (eraseLayer.width !== Math.round(imageData.naturalWidth)) {
                        eraseLayer.width = imageData.naturalWidth;
                        eraseLayer.height = imageData.naturalHeight;
                    }

                    if (!this.drawCanvas) {
                        this.drawCanvas = document.createElement('canvas');
                        this.drawCanvas.width = imageData.naturalWidth;
                        this.drawCanvas.height = imageData.naturalHeight;
                        this.drawCtx = this.drawCanvas.getContext('2d');
                        
                        const img = document.querySelector('.cropper-hide') || this.$refs.image;
                        this.drawCtx.drawImage(img, 0, 0);
                    }
                    
                    if (!this.eraserEventsAttached) {
                        this.eraserEventsAttached = true;
                        const container = this.$refs.image.parentElement;
                        
                        const getCoords = (e) => {
                            let clientX = e.clientX;
                            let clientY = e.clientY;
                            if (e.touches && e.touches.length > 0) {
                                clientX = e.touches[0].clientX;
                                clientY = e.touches[0].clientY;
                            }
                            
                            const cc = document.querySelector('.cropper-canvas');
                            const rect = cc.getBoundingClientRect();
                            const x = clientX - rect.left;
                            const y = clientY - rect.top;
                            
                            const canvasData = this.cropper.getCanvasData();
                            const currentImageData = this.cropper.getImageData();
                            const scaleX = currentImageData.naturalWidth / canvasData.width;
                            const scaleY = currentImageData.naturalHeight / canvasData.height;
                            
                            return {
                                vx: x * scaleX,
                                vy: y * scaleY
                            };
                        };

                        const draw = (e) => {
                            if (!this.isErasing || !this.isDrawing) return;
                            e.preventDefault(); 
                            const coords = getCoords(e);
                            
                            const elayer = document.querySelector('.erase-layer');
                            if (elayer) {
                                const eCtx = elayer.getContext('2d');
                                eCtx.fillStyle = '#ffffff';
                                eCtx.beginPath();
                                eCtx.arc(coords.vx, coords.vy, this.eraserSize / 2, 0, Math.PI * 2);
                                eCtx.fill();
                            }
                            
                            this.drawCtx.fillStyle = '#ffffff';
                            this.drawCtx.beginPath();
                            this.drawCtx.arc(coords.vx, coords.vy, this.eraserSize / 2, 0, Math.PI * 2);
                            this.drawCtx.fill();
                        };

                        container.addEventListener('mousedown', (e) => {
                            if (!this.isErasing) return;
                            e.stopPropagation();
                            e.preventDefault();
                            this.isDrawing = true;
                            draw(e);
                        }, { capture: true });
                        container.addEventListener('touchstart', (e) => {
                            if (!this.isErasing) return;
                            e.stopPropagation();
                            e.preventDefault();
                            this.isDrawing = true;
                            draw(e);
                        }, { passive: false, capture: true });

                        window.addEventListener('mousemove', draw);
                        window.addEventListener('touchmove', draw, {passive: false});

                        const stopDrawing = () => {
                            if (this.isDrawing && this.isErasing) {
                                this.isDrawing = false;
                                this.pendingCropperData = this.cropper.getData();
                                this.cropper.replace(this.drawCanvas.toDataURL('image/jpeg', 1.0), true);
                            }
                            this.isDrawing = false;
                        };

                        window.addEventListener('mouseup', stopDrawing);
                        window.addEventListener('touchend', stopDrawing);
                        
                        this.$refs.image.addEventListener('ready', () => {
                            if (this.pendingCropperData) {
                                this.cropper.setData(this.pendingCropperData);
                                this.pendingCropperData = null;
                            }
                            if (this.isErasing) {
                                this.injectEraseLayer();
                            }
                        });
                    }
                },
                
                getFilterStyle() {
                    return `contrast(${this.contrast}%) saturate(${this.saturation}%) brightness(${this.brightness}%) grayscale(${this.grayscale}%)`;
                },

                applyFilterPreview() {
                    if (!this.cropper) return;
                    const container = this.$refs.image.parentElement;
                    if (container) {
                        const images = container.querySelectorAll('.cropper-canvas img, .cropper-view-box img');
                        const filterStyle = this.getFilterStyle();
                        images.forEach(img => {
                            img.style.filter = filterStyle;
                        });
                    }
                },
                
                applyPresetFilter() {
                    if (this.imageFilter === 'document') {
                        this.brightness = 110;
                        this.contrast = 160;
                        this.saturation = 100;
                        this.grayscale = 100;
                    } else if (this.imageFilter === 'enhance') {
                        this.brightness = 105;
                        this.contrast = 120;
                        this.saturation = 130;
                        this.grayscale = 0;
                    } else if (this.imageFilter === 'none') {
                        this.brightness = 100;
                        this.contrast = 100;
                        this.saturation = 100;
                        this.grayscale = 0;
                    }
                    this.applyFilterPreview();
                },

                setCustomFilter() {
                    this.imageFilter = 'custom';
                    this.applyFilterPreview();
                },

                getFilteredCanvas() {
                    const originalCanvas = this.cropper.getCroppedCanvas({
                        fillColor: '#fff',
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high',
                    });
                    
                    if (this.imageFilter === 'none') {
                        return originalCanvas;
                    }
                    
                    const finalCanvas = document.createElement('canvas');
                    finalCanvas.width = originalCanvas.width;
                    finalCanvas.height = originalCanvas.height;
                    const ctx = finalCanvas.getContext('2d');
                    ctx.filter = this.getFilterStyle();
                    ctx.drawImage(originalCanvas, 0, 0);
                    return finalCanvas;
                },

                handleFile(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.isCropping = true;
                        
                        // Wait for modal to render
                        setTimeout(() => {
                            const imageEl = this.$refs.image;
                            imageEl.src = e.target.result;
                            
                            if (this.cropper) {
                                this.cropper.destroy();
                            }
                            
                            this.cropper = new Cropper(imageEl, {
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 0.95,
                                restore: false,
                                guides: true,
                                center: true,
                                highlight: false,
                                cropBoxMovable: true,
                                cropBoxResizable: true,
                                toggleDragModeOnDblclick: false,
                                ready: () => {
                                    this.applyFilterPreview();
                                }
                            });
                        }, 50);
                    };
                    reader.readAsDataURL(file);
                    
                    // Reset input
                    event.target.value = '';
                },

                rotateImage() {
                    if (this.cropper) {
                        this.cropper.rotate(90);
                    }
                },

                closeModal() {
                    this.isCropping = false;
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                    this.$refs.image.src = '';
                    this.croppedPages = []; // Reset if cancelled
                },
                
                nextPage() {
                    if (!this.cropper) return;
                    
                    this.croppedPages.push(this.getFilteredCanvas());
                    
                    // Close and trigger next upload
                    this.isCropping = false;
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                    this.$refs.image.src = '';
                    
                    setTimeout(() => {
                        this.$refs.fileInput.click();
                    }, 300);
                },

                async shareEmail() {
                    if (!this.cropper) return;
                    
                    // Get current canvas
                    this.croppedPages.push(this.getFilteredCanvas());
                    
                    const fileNameBase = `TP_Update_{{ $tpUpdate->account_number }}`;
                    let shareFiles = [];
                    let fallbackAction = () => {};
                    
                    if (this.exportFormat === 'pdf') {
                        // Generate multi-page PDF
                        const { jsPDF } = window.jspdf;
                        const doc = new jsPDF({
                            orientation: "portrait",
                            unit: "mm",
                            format: "a4"
                        });
                        
                        this.croppedPages.forEach((canvasItem, index) => {
                            if (index > 0) {
                                doc.addPage();
                            }
                            const imgData = canvasItem.toDataURL('image/jpeg', 0.95);
                            const pdfWidth = doc.internal.pageSize.getWidth();
                            const pdfHeight = (canvasItem.height * pdfWidth) / canvasItem.width;
                            doc.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                        });
                        
                        const pdfBlob = doc.output('blob');
                        const pdfFile = new File([pdfBlob], `${fileNameBase}.pdf`, { type: 'application/pdf' });
                        shareFiles.push(pdfFile);
                        
                        fallbackAction = () => {
                            doc.save(`${fileNameBase}.pdf`);
                        };
                    } else {
                        // Generate multiple JPGs
                        const blobPromises = this.croppedPages.map((canvasItem, index) => {
                            return new Promise((resolve) => {
                                canvasItem.toBlob((blob) => {
                                    const suffix = this.croppedPages.length > 1 ? `_Part${index + 1}` : '';
                                    resolve(new File([blob], `${fileNameBase}${suffix}.jpg`, { type: 'image/jpeg' }));
                                }, 'image/jpeg', 0.95);
                            });
                        });
                        shareFiles = await Promise.all(blobPromises);
                        
                        fallbackAction = () => {
                            shareFiles.forEach(file => {
                                const link = document.createElement('a');
                                link.href = URL.createObjectURL(file);
                                link.download = file.name;
                                link.click();
                            });
                        };
                    }
                    
                    // Open Email Client / Share Menu
                    const emailTo = "abd.tp@bankasia-bd.com";
                    const emailCC = "newton.roy@bankasia-bd.com,sm.noman@bankasia-bd.com,m.salahuddin@bankasia-bd.com,mazedul.info@gmail.com";
                    const emailSubject = `Tp update request for ac {{ $tpUpdate->account_number }}`;
                    const emailText = `Dear sir,\n\nPlease find the attached file and make suitable arrangement to update tp.`;
                    
                    const shareData = {
                        files: shareFiles,
                        title: emailSubject,
                        text: emailText
                    };
                    
                    let sharedSuccessfully = false;
                    
                    // Attempt native share API (attaches file directly on supported devices)
                    if (navigator.canShare && navigator.canShare(shareData)) {
                        try {
                            await navigator.share(shareData);
                            sharedSuccessfully = true;
                        } catch (err) {
                            console.warn("Share API failed or user cancelled", err);
                        }
                    }
                    
                    // Fallback for unsupported browsers (Linux Chrome, old browsers)
                    if (!sharedSuccessfully) {
                        fallbackAction(); // Download the files
                        const mailtoBody = `Dear sir,%0D%0A%0D%0APlease find the attached file and make suitable arrangement to update tp.`;
                        window.location.href = `mailto:${emailTo}?cc=${emailCC}&subject=${emailSubject}&body=${mailtoBody}`;
                    }
                    
                    this.closeModal();
                }
            }));
        });
    </script>
</x-app-layout>