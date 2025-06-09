<?php
    $getState = $getState();
    $getTrigger = $getTrigger();
    $getPlacement = $getPlacement();
    $getOffset = $getOffset();
    $getPopOverMaxWidth = $getPopOverMaxWidth();
    $getIcon = $getIcon($getState);
    $descriptionAbove = $getDescriptionAbove();
    $descriptionBelow = $getDescriptionBelow();
    $canWrap = $canWrap();
    $getContent = $getContent();
    $formattedState = $formatState($getState);
    $color = $getColor($state);
?>
<div
    wire:key="<?php echo e($this->getId()); ?>.table.record.<?php echo e($recordKey); ?>.column.<?php echo e($getName()); ?>"
    x-data

    <?php if($getTrigger === 'hover'): ?>
        @pointerleave="$refs.panel.close"
    <?php endif; ?>

    class="fi-popover fi-ta-text grid w-full gap-y-1 px-3 py-4"
>

    <!--[if BLOCK]><![endif]--><?php if(filled($descriptionAbove)): ?>
        <p
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'text-sm text-gray-500 dark:text-gray-400',
                'whitespace-normal' => $canWrap,
            ]); ?>"
        >
            <?php echo e($descriptionAbove); ?>

        </p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div
        style="<?php echo \Illuminate\Support\Arr::toCssStyles([
            \Filament\Support\get_color_css_variables(
                $color,
                shades: [400, 600],
                alias: 'tables::columns.text-column.item.label',
            ) => ! in_array($color, [null, 'gray']),
        ]) ?>"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'text-sm relative w-full fi-popover-trigger cursor-pointer flex items-center gap-2',
            match ($color) {
                null => 'text-gray-950 dark:text-white',
                'gray' => 'text-gray-500 dark:text-gray-400',
                default => 'text-custom-600 dark:text-custom-400',
            },
        ]); ?>"
        <?php if($getTrigger === 'hover'): ?>
            @pointerenter="$refs.panel.open"
        <?php else: ?>
            @click="$refs.panel.toggle"
        <?php endif; ?>
    >
        <?php echo e($formattedState); ?>


        <!--[if BLOCK]><![endif]--><?php if($getIcon): ?>
            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $getIcon,'class' => 'h-4 w-4 text-gray-500 dark:text-gray-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIcon),'class' => 'h-4 w-4 text-gray-500 dark:text-gray-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if(filled($getContent)): ?>
        <div class="z-50 fi-popover-content w-[<?php echo e($getPopOverMaxWidth); ?>px] ring-1 ring-gray-950/5 dark:ring-white/10 rounded-lg shadow-lg bg-white dark:bg-gray-800 transition"
             x-transition:enter-start="opacity-0"
             x-transition:leave-end="opacity-0"
             x-cloak
             x-ref="panel"
             x-float.placement.<?php echo e($getPlacement); ?>.flip.teleport.offset="{ offset: <?php echo e($getOffset); ?> }"
        >
            <?php echo e($getContent); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(filled($descriptionBelow)): ?>
        <p
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'text-sm text-gray-500 dark:text-gray-400',
                'whitespace-normal' => $canWrap,
            ]); ?>"
        >
            <?php echo e($descriptionBelow); ?>

        </p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/vendor/lara-zeus/popover/src/../resources/views/popover-column.blade.php ENDPATH**/ ?>