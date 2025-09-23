<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="<?php echo e(asset('client/login.css')); ?>?v=<?php echo e(filemtime(public_path('client/login.css'))); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="container" id="container">
        
        <div class="form-container sign-up-container">
            <form action="<?php echo e(route('register.pending')); ?>" method="POST" novalidate>
                <?php echo csrf_field(); ?>

                <h1>Create Account</h1>
                <span>Use your data to register</span>

                
                <?php if(session('status')): ?>
                  <div class="alert alert-success" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <?php echo e(session('status')); ?>

                  </div>
                <?php endif; ?>

                <input type="text" name="name" placeholder="Nama Lengkap" value="<?php echo e(old('name')); ?>" required />
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="field-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="text" name="username" placeholder="Username" value="<?php echo e(old('username')); ?>" required />
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="field-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="email" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="field-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="text" name="phone" placeholder="No HP" value="<?php echo e(old('phone')); ?>" required />
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="field-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="password" name="password" placeholder="Password" required />
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="field-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="password" name="password_confirmation" placeholder="Confirm Password" required />

                <button type="submit">Sign Up</button>
            </form>
        </div>

        
        <div class="form-container sign-in-container">
            <form action="<?php echo e(route('login.submit')); ?>" method="POST" novalidate>
                <?php echo csrf_field(); ?> 
                <h1>Sign in</h1>

                
                <?php if(session('status')): ?>
                  <div class="alert alert-success" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <?php echo e(session('status')); ?>

                  </div>
                <?php endif; ?>

                
                <?php if($errors->has('email')): ?>
                  <div class="alert alert-error" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?php echo e($errors->first('email')); ?>

                  </div>
                <?php endif; ?>

                <input type="email" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="field-error"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <input type="password" name="password" placeholder="Password" required />

                <a href="<?php echo e(route('password.request')); ?>">Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>

        
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
</body>

</html>
<?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/guest/login/index.blade.php ENDPATH**/ ?>