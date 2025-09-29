@component('mail::message')
# 🔑 Your One-Time Password (OTP)

Hello **{{ $user->name }}**,

Please use the following code to complete your login to **Purely Home**:

@component('mail::panel')
<h2 style="text-align:center; font-size: 28px; letter-spacing: 5px; margin:0;">
{{ $otp }}
</h2>
@endcomponent

This code will expire in **5 minutes**.

If you did not attempt to log in, please ignore this email.

---

Thanks,<br>
**The Purely Home Team**

@component('mail::subcopy')
If you're having trouble, copy this OTP manually into the login screen: **{{ $otp }}**
@endcomponent
@endcomponent
