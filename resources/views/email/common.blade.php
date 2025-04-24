<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
@php
    use App\Models\Utility;
    $logo = Utility::get_file('uploads/logo');
    // dd($logo)
    $company_logo = Utility::getValByName('company_logo');
@endphp

<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            background-color: #f8f8f8;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        .ReadMsgBody, .ExternalClass {
            width: 100%;
        }

        .ExternalClass * {
            line-height: 100%;
        }

        p {
            display: block;
            margin: 13px 0;
        }

        .outlook-group-fix {
            width: 100% !important;
        }

        @media only screen and (max-width: 480px) {
            table.full-width-mobile {
                width: 100% !important;
            }

            td.full-width-mobile {
                width: auto !important;
            }

            @-ms-viewport {
                width: 320px;
            }

            @viewport {
                width: 320px;
            }
        }

        @media only screen and (min-width: 480px) {
            .mj-column-per-100 {
                width: 100% !important;
                max-width: 100%;
            }
        }

        [owa] .mj-column-per-100 {
            width: 100% !important;
            max-width: 100%;
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
</head>

<body>
    <div style="background-color:#f8f8f8;">
        <!-- Header Section -->
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
            <tr>
                <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
                    <div style="background:#ffffff; max-width:600px; margin:0 auto;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" style="background:#ffffff; width:100%;">
                            <tr>
                                <td style="padding:0; text-align:center;">
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="width:600px;">
                                                <div class="mj-column-per-100 outlook-group-fix" style="text-align:left;">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td style="padding:10px 0 40px;">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                    <tr>
                                                                        <td style="border-top:solid 7px #6676EF;"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" style="padding-bottom:10px;">
                                                                <img src="{{ $logo . '/' . (!empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                                                                     alt="Logo"
                                                                     width="110"
                                                                     style="display:block; width:110px; height:auto;">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Content Section -->
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
            <tr>
                <td>
                    <div>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" style="background:#ffffff; width:100%;">
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="mj-column-per-100 outlook-group-fix">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td style="padding:25px;">
                                                                @yield('content')
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
