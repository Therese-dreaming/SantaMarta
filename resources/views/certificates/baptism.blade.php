<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 20px;
            size: portrait;
        }

        @font-face {
            font-family: 'oldenglishfive';
            src: url('{{ storage_path("app/public/fonts/OldEnglishFive.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'georgia';
            src: url('{{ storage_path("app/public/fonts/georgia.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Times New Roman', serif;
            text-align: center;
            background: #fff;
            position: relative;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .inner-border {
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 4px solid #8B4513;
            border-radius: 8px;
            pointer-events: none;
            z-index: 0;
        }

        .logo-container {
            display: flex;
            justify-content: space-between;
            margin: 10px 50px;
            margin-top: 40px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .header {
            margin: 10px 0;
        }

        .parish-name {
            font-size: 24px;
            font-weight: bold;
            color: #8B4513;
            margin: 5px 0;
            font-family: 'georgia', 'Times New Roman', serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .title {
            font-family: 'oldenglishfive', 'Times New Roman', serif;
            font-size: 28px;
            margin: 20px 0;
            color: #8B4513;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .parish-address {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .subtitle {
            font-style: italic;
            margin: 10px 0 20px;
            font-size: 16px;
        }

        .content {
            width: 80%;
            margin: 0 auto;
            line-height: 1.6;
            font-size: 14px;
        }

        .field-line {
            border-bottom: 1px solid #8B4513;
            min-width: 250px;
            display: inline-block;
            margin: 0 5px;
        }

        .signature-section {
            margin-top: 40px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            padding: 0 50px; /* Reduced padding to allow more space */
        }

        .signature-line {
            border-top: 1px solid #8B4513;
            width: 200px;
            padding-top: 5px;
            font-style: italic;
            color: #666;
        }

        /* Add specific alignment for each signature */
        .signature-left {
            text-align: left;
        }

        .signature-right {
            text-align: right;
            margin: 0 auto;
            padding-top: 5px;
            font-style: italic;
            color: #666;
        }

        .scripture {
            font-style: italic;
            font-size: 12px;
            margin: 20px 0;
            color: #8B4513;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            opacity: 0.1;
            width: 350px;
            height: auto;
            pointer-events: none;
            z-index: -1;
        }

    </style>
</head>
<body>
    <div class="certificate-border">
        <div class="inner-border"></div>

        <div class="logo-container">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/LOGO-1.png'))) }}" alt="Logo 1" class="logo">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/LOGO-2.png'))) }}" alt="Logo 2" class="logo">
        </div>

        <div class="header">
            <div class="parish-name">SANTA MARTA PARISH</div>
            <div class="parish-address">Diocese of Pasig</div>
        </div>

        <div class="title">Baptismal Certificate</div>
        <div class="subtitle">This is to Certify</div>

        <div class="content">
            <p>That <span class="field-line">{{ $details->child_name }}</span></p>
            <p>Child of <span class="field-line">{{ $details->father_name }}</span></p>
            <p>And <span class="field-line">{{ $details->mother_name }}</span></p>
            <p>Born in <span class="field-line">{{ $details->place_of_birth }}</span></p>
            <p>On the <span class="field-line">{{ Carbon\Carbon::parse($details->date_of_birth)->format('jS') }}</span>
                day of <span class="field-line">{{ Carbon\Carbon::parse($details->date_of_birth)->format('F') }}</span>,
                Year <span class="field-line">{{ Carbon\Carbon::parse($details->date_of_birth)->format('Y') }}</span></p>
            <p>was solemnly Baptized according to the Rites of the Roman Catholic Church</p>
            <p>On the <span class="field-line">{{ Carbon\Carbon::parse($details->baptism_date)->format('jS') }}</span>
                day of <span class="field-line">{{ Carbon\Carbon::parse($details->baptism_date)->format('F') }}</span>,
                Year <span class="field-line">{{ Carbon\Carbon::parse($details->baptism_date)->format('Y') }}</span></p>
            <p>By the Rev. <span class="field-line">{{ $details->priest_name }}</span></p>
        </div>

        <div class="scripture">
            "Go and make disciples of all nations, baptizing them in the name of<br>
            the Father and of the Son and of the Holy Spirit" - Matthew 28:19
        </div>

        <div class="signature-section">
            <div class="signature-left">
                <div class="signature-line">Parish Priest</div>
            </div>
            <div class="signature-right">
                <div class="signature-line">Parish Seal</div>
            </div>
        </div>

        <div class="watermark"><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/Sta-Marta.png'))) }}" alt="Watermark" style="width: 100%; height: 100%;"></div>
    </div>
</body>
</html>
