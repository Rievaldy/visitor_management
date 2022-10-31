<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        {{--
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        --}}
    </head>
    <body style="background-color: #F9F9F9;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
            <tbody>
                <tr>
                    <td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
                        <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperWebview">
                                            <tbody>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <!-- Content Table Open // -->
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" valign="middle" style="padding-top: 20px; padding-bottom: 10px;" class="emailLogo">
                                                                        <!-- Logo and Link // -->
                                                                        <a href="#" target="_blank" style="text-decoration:none;">
                                                                        <img src="https://ykk.ofisdev.com/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;">
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Content Table Close // -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Table Card Open // -->
                                        <table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">
                                            <tbody>
                                                <tr>
                                                    <!-- Header Top Border // -->
                                                    <td height="3" style="background-color:#94cac1;font-size:1px;line-height:3px;" class="topBorder">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px; padding-top: 30px; padding-bottom: 30px" class="mainTitle">
                                                        <!-- Main Title Text // -->
                                                        <h2 class="text" style="color:#333333; font-family: 'Poppins', sans-serif; font-size:28px; font-weight:500; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
                                                            Thank You
                                                        </h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top" style="padding-left:20px;padding-right:20px;" class="containtTable ui-sortable">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDivider">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" valign="top" style="padding-top:0px;padding-bottom:40px;">
                                                                        <!-- Divider // -->
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td height="1" style="background-color:#E5E5E5;font-size:1px;line-height:1px;" class="divider">&nbsp;</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableSmllTitle">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" valign="top" style="padding-bottom:10px;" class="smllTitle">
                                                                        <!-- Small Title Text // -->
                                                                        <p class="text" style="color:#333333; font-family: 'Poppins', sans-serif; font-size:16px; font-weight:500; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:left; padding:0; margin:0">
                                                                            System will send notification to your email address if your visit plan approved
                                                                            <br>
                                                                            <br>
                                                                            Your Visit ID: {{ ($datas[0]->type == '1') ? 'VS' : 'VSN' }}{{ $visitID }}
                                                                            <br>
                                                                            Use this ID for your next access to system
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDivider">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" valign="top" style="padding-top:20px;padding-bottom:40px;">
                                                                        <!-- Divider // -->
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td height="1" style="background-color:#E5E5E5;font-size:1px;line-height:1px;" class="divider">&nbsp;</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" valign="top" style="padding-bottom:20px;" class="description">
                                                                        <!-- Description Text// -->
                                                                        <p class="text" style="color:#333333; font-family: 'Poppins', sans-serif; font-size:14px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:left; padding:0; margin:0">
                                                                            Special Policy for Visitor:
                                                                        </p>
                                                                        <ol style="padding-left: 14px">
                                                                        <li style="color:#333333; font-family: 'Poppins', sans-serif; font-size:14px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:left; padding:0; margin:0">
                                                                            During the Covid-19 pandemic, all visitors who will make visit more than 15
                                                                            minutes are required to bring/show Result of <span style="font-weight: 500">Rapid Test Antigen/PCR-Negatif</span>
                                                                            which were obtained within 14 days before visit schedule.
                                                                        </li>
                                                                        <li style="color:#333333; font-family: 'Poppins', sans-serif; font-size:14px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:left; padding:0; margin:0">
                                                                            <span style="font-weight: 500">Prepare your Own Tumbler</span> because PT YKK Zipper Indonesia will not provide
                                                                            pet bottle mineral water as our commitment toward environment
                                                                            sustainability.
                                                                        </li>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButtonDate">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" valign="top" style="padding-bottom:40px;" class="infoDate">
                                                                        <!-- Info Date // -->
                                                                        <p class="text" style="color:#333333; font-family: 'Poppins', sans-serif; font-size:11px; font-weight:700; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0">
                                                                            Notes: This form applies to institution.
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Table Card Close// -->
                                        <!-- Space -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
                                            <tbody>
                                                <tr>
                                                    <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
                                        <!-- Social Links (Facebook)// -->
                                        <a href="https://www.facebook.com/YKKZipperIndonesia/" target="_blank" style="display: inline-block;" class="facebook">
                                        <img src="http://weekly.grapestheme.com/notify/img/social/light/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px">
                                        </a>
                                        <!-- Social Links (Twitter)// -->
                                        <a href="https://mobile.twitter.com/ykkfasteners" target="_blank" style="display: inline-block;" class="twitter">
                                        <img src="http://weekly.grapestheme.com/notify/img/social/light/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px">
                                        </a>
                                        <!-- Social Links (Instagram)// -->
                                        <a href="https://www.instagram.com/ykk_indonesia/?hl=en" target="_blank" style="display: inline-block;" class="instagram">
                                        <img src="http://weekly.grapestheme.com/notify/img/social/light/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px">
                                        </a>
                                        <!-- Social Links (Linkdin)// -->
                                        <a href="https://www.linkedin.com/company/ykk" target="_blank" style="display: inline-block;" class="linkdin">
                                        <img src="http://weekly.grapestheme.com/notify/img/social/light/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px">
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
                                        <!-- Brand Information // -->
                                        <p class="text" style="color:#777777; font-family: 'Poppins', sans-serif; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">©&nbsp;PT YKK Zipper Indonesia. | Jl. Raya Jakarta Bogor Km 29 Cimanggis, Depok 16451.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
                                        <!-- Information of NewsLetter (Subscribe Info)// -->
                                        <p class="text" style="color:#777777; font-family: 'Poppins', sans-serif; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">
                                            If you have any quetions please contact us <a href="#" style="color:#777777;text-decoration:underline;" target="_blank">smartoffice@ykk.ofisdev.com.</a>
                                        </p>
                                    </td>
                                </tr>
                                <!-- Space -->
                                <tr>
                                    <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>