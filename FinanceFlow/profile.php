<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user=current_user($pdo);
$page_title='Profile & Settings';
$errors=[];

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??'');
    $email=trim($_POST['email']??'');
    $current=$_POST['current_password']??'';
    $new=$_POST['new_password']??'';
    $confirm=$_POST['confirm_password']??'';

    if($name===''||mb_strlen($name)<2)$errors[]='Please enter a valid name.';
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))$errors[]='Please enter a valid email.';
    $stmt=$pdo->prepare("SELECT id FROM users WHERE email=? AND id<>?");
    $stmt->execute([$email,$user['id']]);
    if($stmt->fetch())$errors[]='That email is already in use.';

    if($new!==''){
        $stmt=$pdo->prepare("SELECT password FROM users WHERE id=?");$stmt->execute([$user['id']]);$dbUser=$stmt->fetch();
        if(!password_verify($current,$dbUser['password']))$errors[]='Current password is incorrect.';
        if(strlen($new)<8)$errors[]='New password must contain at least 8 characters.';
        if($new!==$confirm)$errors[]='New passwords do not match.';
    }

    if(!$errors){
        if($new!==''){
            $hash=password_hash($new,PASSWORD_DEFAULT);
            $stmt=$pdo->prepare("UPDATE users SET name=?,email=?,password=? WHERE id=?");$stmt->execute([$name,$email,$hash,$user['id']]);
        }else{
            $stmt=$pdo->prepare("UPDATE users SET name=?,email=? WHERE id=?");$stmt->execute([$name,$email,$user['id']]);
        }
        $_SESSION['user_name']=$name; flash('success','Profile updated successfully.'); header('Location: profile.php');exit;
    }
    $user=array_merge($user,['name'=>$name,'email'=>$email]);
}
include __DIR__ . '/includes/header.php';
?>
<div class="form-card"><h2>Profile settings</h2><p class="muted">Update your account information or change your password.</p>
<?php foreach($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="form-grid two">
<label>Full name<input name="name" value="<?= e($user['name']) ?>" required></label>
<label>Email address<input type="email" name="email" value="<?= e($user['email']) ?>" required></label>
<div class="section-divider span-2"><span>Change password (optional)</span></div>
<label>Current password<input type="password" name="current_password" autocomplete="current-password"></label>
<label>New password<input type="password" name="new_password" minlength="8" autocomplete="new-password"></label>
<label>Confirm new password<input type="password" name="confirm_password" minlength="8" autocomplete="new-password"></label>
<div class="form-actions"><button class="btn btn-primary btn-lg" type="submit">Save changes</button></div>
</form>
<div class="profile-meta">Account created: <?= date('d M Y',strtotime($user['created_at'])) ?></div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>