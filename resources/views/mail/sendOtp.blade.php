<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Untitled Document</title>
</head>

<body>
    <table width="890" style="border-top:2px solid; border-color: #dedede; padding-top:17px;padding-bottom: 15px"
        cellspacing="0" cellpadding="0">
        <tr>
            <th width="886" bordercolor="#dedede" scope="col"
                style="font-family: Helvetica; font-weight: 500; font-size: 14px">
                <div align="left" style="font-weight: 500;font-family: Helvetica;line-height: 1.5; color:#353333">

                    Dear {{ $name }}, <br />

                    <p><b>Thank you for registering with the Campus Connect Portal.</b></p>

                    <p>To complete your registration, please use the One-Time Password (OTP) provided below. This OTP is
                        valid for the next 15 minutes.</p>

                    <p><b>Your OTP: {{ $OTP }}</b></p>

                    <p>Please enter this OTP on the verification page to activate your account.</p>

                    <p>If you did not request this OTP, please ignore this email or contact our support team
                        immediately.</p>

                    <b>Thank you,</b><br>

                    <b>The Campus Connect Team</b>

                </div>
            </th>
        </tr>
    </table>


</body>

</html>
