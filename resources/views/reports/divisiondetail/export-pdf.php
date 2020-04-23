<html >
<head>

    <style media="screen">
/*
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabun.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabun Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunN Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabun BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
        }



*/
       @font-face {
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabun.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabun-Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabun';
            font-style: italic;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabun-Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabun';
            font-style: italic;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabun-Bold-Italic.ttf') }}") format('truetype');
        }
body {
	font-family: 'THSarabun', sans-serif;
}


    </style>
</head>
<body>
<h1>ใบแจ้งหนี้สำหรับ </h1>
ขอขอบคุณในการสั่งซื้อ
<br>Hello
<?php
echo $foo;
?>

</body>
</html>
