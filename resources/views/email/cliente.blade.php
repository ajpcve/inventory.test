<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!--[if gte mso 9]><xml>
        <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml><![endif]-->
    <!-- fix outlook zooming on 120 DPI windows devices -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
    <meta name="format-detection" content="date=no"> <!-- disable auto date linking in iOS 7-9 -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS 7-9 -->

    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        table  {
            /*border-spacing: 0;
            border: 2px solid #bde199*/
        }
        table td {
            border-collapse: collapse;
        }
        .ExternalClass {
            width: 100%;
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }
        .ReadMsgBody {
            width: 100%;
            background-color: #ebebeb;
        }
        table {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
        }
        .yshortcuts a {
            border-bottom: none !important;
        }
        @media screen and (max-width: 599px) {
            .force-row,
            .container {
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        @media screen and (max-width: 400px) {
            .container-padding {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
        }
        .ios-footer a {
            color: #aaaaaa !important;
            text-decoration: underline;
        }
        a[href^="x-apple-data-detectors:"],
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
    </style>
</head>

<body style="margin:0; padding:0;"  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

    <!-- 100% background wrapper (grey background) -->
    <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top" >
                <br>

                <!-- 600px container (white background) -->
                <table border="0" cellpadding="0" cellspacing="0" class="img-wrapper">
                    <tr>
                        <td style="padding-bottom:18px"><img src="{{ $message->embed($logo) }}" border="0" alt="Bufalinda" width="58" height="58" hspace="0" vspace="0" style="max-width:100%; " class="image"></td>
                    </tr>
                </table>
                <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px">
                    <tr>
                        <td class="container-padding header" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:12px;color:#698836;padding-left:24px;padding-right:24px">
                            BUFALINDA USA - BILL OF LADING
                        </td>
                    </tr>
                    <tr>
                        <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
                            <div class="title" style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#374550">Dear {!! $cab_sale_inv->cust->cust_company !!}</div>

                            <div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
                                <p> Please find enclosed the confirmation of your order.
                                    <br>
                                    It is a pleasure doing business with you.
                                    <br>
                                    Please contact <a href="mailto:{!! $cab_sale_inv->user->email !!}">{!! $cab_sale_inv->user->email !!}</a>  if you have any questions or call 786-505-9513. 
                                    <br><br>
                                    Best,
                                    <br><br>
                                    Bufalinda USA
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="container-padding footer-text" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:16px;color:#aaaaaa;padding-left:24px;padding-right:24px">
                            "This message may contain confidential, proprietary or legally privileged information and is intended only for the use of the addressee named above. If you are not the intended recipient of this message you are hereby informed that you must not use, disseminate, copy it in any form or take any action in reliance on it. If you have received this message in error please delete it and any copies of it and notify it to the sender”
                            <br><br>
                            <span class="ios-footer">
                                "Este mensaje puede contener información confidencial, en propiedad o legalmente protegida y está dirigida únicamente para el uso de la persona destinataria. Si usted no es la persona destinataria de este mensaje, se le comunica que no debe usar, difundir, copiar de ninguna forma, ni emprender ninguna acción en relación con ella. Si usted ha recibido este mensaje por error, por favor le rogamos que lo borre, al igual que cualquier copia del mismo y notifique este hecho al remitente."<br>
                            </span>
                            <br><br>
                        </td>
                    </tr>
                </table>
                <!--/600px container -->
            </td>
        </tr>
    </table>
    <!--/100% background wrapper-->
</body>
</html>