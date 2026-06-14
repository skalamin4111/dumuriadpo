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

            /* Compensate for the 0 page margin in the document container */
            .print-doc {
                padding-top: 10mm !important;
                padding-bottom: 10mm !important;
                padding-left: 15mm !important;
                padding-right: 15mm !important;
                max-width: 100% !important;
            }
        }

        .print-doc {
            font-family: 'SolaimanLipi', 'Kalpurush', 'Siyam Rupali', Arial, sans-serif;
            color: #000;
            max-width: 210mm;
            /* A4 width */
            margin: 0 auto;
            background: #fff;
            padding: 15px 40px;
            box-sizing: border-box;
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
    </style>

    <div class="mb-6 flex items-center justify-between no-print" x-data="tpDocumentUpload({{ $expectedPages }})">
        <a href="{{ route('bank-asia.tp-updates.index') }}" class="btn btn-muted">
            <svg class="size-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Back to List
        </a>
        <div class="flex gap-3">
            <button onclick="window.print()" class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white border-transparent">
                <svg class="size-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                Print Document
            </button>
            <button @click="$refs.fileInput.click()" class="btn btn-primary bg-teal-600 hover:bg-teal-700 text-white border-transparent">
                <svg class="size-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
                Upload Signed Doc
            </button>
            <input type="file" x-ref="fileInput" @change="handleFile" accept="image/*" class="hidden" capture="environment">
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
                <div class="bg-slate-800 p-3 sm:p-4 shrink-0 shadow-[0_-10px_40px_rgba(0,0,0,0.3)] flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 border-t border-slate-700/80 z-10 w-full" style="padding-bottom: calc(12px + env(safe-area-inset-bottom));">
                    <div class="flex items-center justify-between w-full sm:w-auto shrink-0 order-1 sm:order-none">
                        <label class="text-xs sm:text-sm font-medium text-slate-300 whitespace-nowrap mr-2">Format:</label>
                        <select x-model="exportFormat" class="block w-full sm:w-32 rounded-lg border-slate-600 bg-slate-700/50 text-white text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 py-1.5 sm:py-2">
                            <option value="pdf">PDF (Default)</option>
                            <option value="jpg">JPG Image</option>
                        </select>
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
    </div>

    <div id="print-area">
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

    <!-- Include Cropper.js & jsPDF -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tpDocumentUpload', (expectedPages = 1) => ({
                isCropping: false,
                cropper: null,
                exportFormat: 'pdf',
                expectedPages: expectedPages,
                croppedPages: [],

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
                    
                    const canvas = this.cropper.getCroppedCanvas({
                        fillColor: '#fff',
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high',
                    });
                    
                    this.croppedPages.push(canvas);
                    
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
                    const canvas = this.cropper.getCroppedCanvas({
                        fillColor: '#fff',
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high',
                    });
                    this.croppedPages.push(canvas);
                    
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