<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="<?php echo e(__('Pagination Navigation')); ?>">

        <div class="flex gap-2 items-center justify-between sm:hidden">

            <?php if($paginator->onFirstPage()): ?>
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-white border border-slate-200 cursor-not-allowed leading-5 rounded-lg dark:text-slate-500 dark:bg-slate-800/50 dark:border-slate-700">
                    <?php echo __('pagination.previous'); ?>

                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 leading-5 rounded-lg hover:text-teal-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500/20 active:bg-slate-100 active:text-slate-800 transition ease-in-out duration-150 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:text-teal-400 dark:active:bg-slate-700 dark:active:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80">
                    <?php echo __('pagination.previous'); ?>

                </a>
            <?php endif; ?>

            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 leading-5 rounded-lg hover:text-teal-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500/20 active:bg-slate-100 active:text-slate-800 transition ease-in-out duration-150 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:text-teal-400 dark:active:bg-slate-700 dark:active:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80">
                    <?php echo __('pagination.next'); ?>

                </a>
            <?php else: ?>
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-white border border-slate-200 cursor-not-allowed leading-5 rounded-lg dark:text-slate-500 dark:bg-slate-800/50 dark:border-slate-700">
                    <?php echo __('pagination.next'); ?>

                </span>
            <?php endif; ?>

        </div>

        <div class="hidden sm:flex-1 sm:flex sm:gap-2 sm:items-center sm:justify-between">

            <div>
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-600">
                    <?php echo __('Showing'); ?>

                    <?php if($paginator->firstItem()): ?>
                        <span class="font-medium"><?php echo e($paginator->firstItem()); ?></span>
                        <?php echo __('to'); ?>

                        <span class="font-medium"><?php echo e($paginator->lastItem()); ?></span>
                    <?php else: ?>
                        <?php echo e($paginator->count()); ?>

                    <?php endif; ?>
                    <?php echo __('of'); ?>

                    <span class="font-medium"><?php echo e($paginator->total()); ?></span>
                    <?php echo __('results'); ?>

                </p>
            </div>

            <div>
                <span class="inline-flex rtl:flex-row-reverse shadow-sm rounded-lg overflow-hidden">

                    
                    <?php if($paginator->onFirstPage()): ?>
                        <span aria-disabled="true" aria-label="<?php echo e(__('pagination.previous')); ?>">
                            <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-slate-400 bg-white border-y border-l border-slate-200 cursor-not-allowed leading-5 dark:bg-slate-800/50 dark:border-slate-700 dark:text-slate-500" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="inline-flex items-center px-3 py-2 text-sm font-medium text-slate-500 bg-white border-y border-l border-slate-200 leading-5 hover:text-teal-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500/20 active:bg-slate-100 transition ease-in-out duration-150 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:text-teal-400 dark:hover:bg-slate-800/80" aria-label="<?php echo e(__('pagination.previous')); ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if(is_string($element)): ?>
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-slate-700 bg-white border-y border-l border-slate-200 cursor-default leading-5 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300"><?php echo e($element); ?></span>
                            </span>
                        <?php endif; ?>

                        
                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-white bg-teal-600 border border-teal-600 cursor-default leading-5 dark:bg-teal-500 dark:border-teal-500 shadow-inner"><?php echo e($page); ?></span>
                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-slate-700 bg-white border-y border-l border-slate-200 leading-5 hover:text-teal-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500/20 active:bg-slate-100 transition ease-in-out duration-150 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:text-teal-400 dark:hover:bg-slate-800/80" aria-label="<?php echo e(__('Go to page :page', ['page' => $page])); ?>">
                                        <?php echo e($page); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($paginator->hasMorePages()): ?>
                        <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-slate-500 bg-white border border-slate-200 leading-5 hover:text-teal-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500/20 active:bg-slate-100 transition ease-in-out duration-150 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:text-teal-400 dark:hover:bg-slate-800/80" aria-label="<?php echo e(__('pagination.next')); ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php else: ?>
                        <span aria-disabled="true" aria-label="<?php echo e(__('pagination.next')); ?>">
                            <span class="inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-slate-400 bg-white border border-slate-200 cursor-not-allowed leading-5 dark:bg-slate-800/50 dark:border-slate-700 dark:text-slate-500" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>