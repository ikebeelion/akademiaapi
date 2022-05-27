@component('mail::message')
Hello,

Your Akademia Password is
<div style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';text-align: center !important; font-size: 13px;margin-bottom:20px">
<p style="background-color:#000;margin: auto;width: 40%;text-align:center;padding:5px;border-radius:5px;">
<span style="display:block;font-size:12px">Password</span>
<span style="display:block;color: #ffffff">{{ $password }}</span>
</p>
</div>


Education is Key!<br>
{{ config('app.name') }} Team

<div class="table" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; padding-bottom: 10px; text-align: center; font-size: 13px">
Please do not reply to this email. If you need help, please contact the administrator.
</div>
@endcomponent
