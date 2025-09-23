<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('client/course.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Learnify - Courses'); ?>

<?php $__env->startSection('content'); ?>
<section class="course-page">
    
    <form method="GET" action="<?php echo e(route('course.index')); ?>" class="sidebar" data-aos="fade-right" id="filterForm">
        <h2>Course</h2>
        <label>
            <input type="checkbox" name="all" value="1" <?php echo e(request('all') ? 'checked' : ''); ?>> All Courses
        </label>
        <label>
            <input type="checkbox" name="my" value="1" <?php echo e(request('my') ? 'checked' : ''); ?>> My Courses
        </label>
        <label>
            <input type="checkbox" name="available" value="1" <?php echo e(request('available') ? 'checked' : ''); ?>> Available Courses
        </label>

        
        <h2>Category</h2>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label>
                <input type="checkbox" name="categories[]" value="<?php echo e($category->id); ?>"
                    <?php echo e(in_array($category->id, request()->input('categories', [])) ? 'checked' : ''); ?>>
                <?php echo e($category->category); ?>

            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <h2>Price</h2>
        <label>
            <input type="radio" name="price" value=""
                <?php echo e(request('price') === null || request('price') === '' ? 'checked' : ''); ?>> All Prices
        </label>
        <label>
            <input type="radio" name="price" value="free"
                <?php echo e(request('price') === 'free' ? 'checked' : ''); ?>> Free
        </label>
        <?php $__currentLoopData = $priceRanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label>
                <input type="radio" name="price" value="<?php echo e($price->id); ?>"
                    <?php echo e(request('price') == $price->id ? 'checked' : ''); ?>>
                $<?php echo e($price->min_price); ?> - $<?php echo e($price->max_price); ?>

            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <h2>Level</h2>
        <label>
            <input type="radio" name="level" value=""
                <?php echo e(request('level') === null || request('level') === '' ? 'checked' : ''); ?>> All Levels
        </label>
        <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label>
                <input type="radio" name="level" value="<?php echo e($level->id); ?>"
                    <?php echo e(request('level') == $level->id ? 'checked' : ''); ?>>
                <?php echo e($level->level); ?>

            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </form>

    
    <div class="courses">
        <h1 data-aos="fade-up">All Courses</h1>
        <p data-aos="fade-up" data-aos-delay="100">Browse our wide selection of online courses</p>
        <div class="course-grid">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a class="course-card" href="<?php echo e(route('detail.index', $course->slug)); ?>" data-aos="zoom-in"
                    data-aos-delay="<?php echo e($index * 50); ?>">
                    
                    
                    <div class="card-image">
                        <div class="img-protected"
                            style="background-image: url('<?php echo e(asset('storage/' . $course->img)); ?>');"
                            title="<?php echo e($course->name); ?>">
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <h3><?php echo e($course->name); ?></h3>
                        <span class="category"><?php echo e($course->category->category ?? '-'); ?></span>

                        
                        <p class="price">
                            <?php if($course->price == 0): ?>
                                Free
                            <?php else: ?>
                                $<?php echo e(number_format($course->price, 2)); ?>

                            <?php endif; ?>
                        </p>

                        
                        <div class="info">
                            <span><i class="fa-regular fa-clock"></i> <?php echo e($course->formatted_duration); ?></span>
                            <span><i class="fa-solid fa-book"></i> <?php echo e($course->lessons_count ?? 0); ?> Modul</span>
                        </div>

                        
                        <div class="meta">
                            <div class="rating">
                                <?php
                                    $rating = round($course->reviews_avg_rating ?? 0, 1);
                                    $fullStars = floor($rating);
                                    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;
                                ?>

                                
                                <?php for($i = 0; $i < $fullStars; $i++): ?>
                                    <i class="fas fa-star"></i>
                                <?php endfor; ?>

                                
                                <?php if($halfStar): ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php endif; ?>

                                
                                <?php for($i = 0; $i < $emptyStars; $i++): ?>
                                    <i class="far fa-star"></i>
                                <?php endfor; ?>

                                <span class="rating-text">(<?php echo e($rating); ?>)</span>
                            </div>
                            <div class="students">
                                <i class="fa-solid fa-users"></i> <?php echo e($course->students_count ?? 0); ?>

                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>No courses found for the selected filters.</p>
            <?php endif; ?>
        </div>

        
        <div class="pagination">
            <?php echo e($courses->links()); ?>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

    // Auto submit filter
    document.querySelectorAll('#filterForm input').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });

    // Disable klik kanan khusus gambar
    document.addEventListener('contextmenu', e => {
        if (e.target.closest('.img-protected')) {
            e.preventDefault();
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/course/index.blade.php ENDPATH**/ ?>