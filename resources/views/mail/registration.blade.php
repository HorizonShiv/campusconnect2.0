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

                    <p><b>Congratulations! Your registration for the Campus Connect platform has been successfully
                            completed.</b></p>

                    <p>We are thrilled to have you join our community. Below, you will find your login credentials to
                        access the platform. Please keep this information secure and do not share it with anyone.</p>

                    <p><b>Username: {{ $email }}</b></p>
                    <p><b>Password: {{ $password }}</b></p>

                    <p>To log in, please visit <a href="https://campusconnect.stellarnova.in/authenticate/login">Campus
                            Connect Login URL</a> and enter your credentials. If you encounter
                        any
                        issues or have any questions, our support team is here to assist you.</p>

                    <p>Thank you for registering with Campus Connect. We look forward to your active participation and
                        hope
                        you find great value in the resources and connections available on our platform.</p>

                    <b>Best regards,</b><br>

                    <b>The Campus Connect Team</b>

                </div>
            </th>
        </tr>
    </table>


</body>

</html>
