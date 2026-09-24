<?php
// =========================================================
// SimplePDF — pembuat PDF sederhana TANPA library eksternal
// A4 LANDSCAPE agar tabel laporan tidak terpotong.
// =========================================================

class SimplePDF
{
    private array $pages = [];
    private string $currentContent = "";

    // A4 LANDSCAPE = 842 x 595 point
    private float $y;

    private float $lineHeight = 16;

    // Posisi awal dari atas
    private float $marginTop = 550;

    // Batas bawah
    private float $marginBottom = 40;

    // Margin kiri
    private float $marginLeft = 40;

    public function __construct()
    {
        $this->startPage();
    }

    // =====================================================
    // MULAI HALAMAN
    // =====================================================
    private function startPage(): void
    {
        $this->currentContent = "BT /F1 10 Tf\n";

        $this->y = $this->marginTop;
    }

    // =====================================================
    // AKHIR HALAMAN
    // =====================================================
    private function endPage(): void
    {
        $this->currentContent .= "ET";

        $this->pages[] = $this->currentContent;
    }

    // =====================================================
    // TAMBAH BARIS
    // =====================================================
    public function addLine(
        string $text,
        int $size = 10,
        float $x = 40
    ): void {

        if ($this->y < $this->marginBottom) {

            $this->endPage();

            $this->startPage();
        }

        $safe = $this->escape($text);

        $this->currentContent .=
            "1 0 0 1 {$x} {$this->y} Tm " .
            "/F1 {$size} Tf " .
            "({$safe}) Tj\n";

        $this->y -= $this->lineHeight;
    }

    // =====================================================
    // TAMBAH BARIS DI TENGAH
    // =====================================================
    public function addCenteredLine(
        string $text,
        int $size = 10
    ): void {

        /*
         * Courier kira-kira 0.6 point per karakter
         */
        $textWidth = strlen($text) * ($size * 0.6);

        /*
         * Lebar halaman landscape = 842
         */
        $x = (842 - $textWidth) / 2;

        if ($x < 30) {
            $x = 30;
        }

        $this->addLine(
            $text,
            $size,
            $x
        );
    }

    // =====================================================
    // TAMBAH SPASI VERTIKAL
    // =====================================================
    public function addSpace(float $space = 10): void
    {
        $this->y -= $space;
    }

    // =====================================================
    // ESCAPE KARAKTER PDF
    // =====================================================
    private function escape(string $text): string
    {
        return str_replace(
            ['\\', '(', ')'],
            ['\\\\', '\\(', '\\)'],
            $text
        );
    }

    // =====================================================
    // OUTPUT PDF
    // =====================================================
    public function output(string $filename): void
    {
        $this->endPage();

        $objects = [];

        /*
         * OBJECT CATALOG
         */
        $objects[1] =
            "<< /Type /Catalog /Pages 2 0 R >>";

        $objIndex = 3;

        $pageObjIds = [];

        foreach ($this->pages as $i => $content) {

            $pageObjIds[$i] = $objIndex++;
        }

        $contentObjIds = [];

        foreach ($this->pages as $i => $content) {

            $contentObjIds[$i] = $objIndex++;
        }

        $fontObjId = $objIndex;

        /*
         * KIDS
         */
        $kids = implode(
            ' ',
            array_map(
                fn($id) => "$id 0 R",
                $pageObjIds
            )
        );

        /*
         * A4 LANDSCAPE
         *
         * 842 x 595
         */
        $objects[2] =
            "<< /Type /Pages " .
            "/Kids [$kids] " .
            "/Count " . count($this->pages) .
            " >>";

        /*
         * PAGE OBJECT
         */
        foreach ($this->pages as $i => $content) {

            $pid = $pageObjIds[$i];

            $cid = $contentObjIds[$i];

            $objects[$pid] =
                "<< /Type /Page " .
                "/Parent 2 0 R " .
                "/MediaBox [0 0 842 595] " .
                "/Resources << " .
                "/Font << " .
                "/F1 {$fontObjId} 0 R " .
                ">> " .
                ">> " .
                "/Contents {$cid} 0 R >>";
        }

        /*
         * CONTENT OBJECT
         */
        foreach ($this->pages as $i => $content) {

            $cid = $contentObjIds[$i];

            $len = strlen($content);

            $objects[$cid] =
                "<< /Length {$len} >>\n" .
                "stream\n" .
                $content .
                "\nendstream";
        }

        /*
         * COURIER
         *
         * Monospace supaya tabel tetap sejajar.
         */
        $objects[$fontObjId] =
            "<< /Type /Font " .
            "/Subtype /Type1 " .
            "/BaseFont /Courier >>";

        /*
         * BUILD PDF
         */
        $pdf = "%PDF-1.4\n";

        $offsets = [];

        ksort($objects);

        foreach ($objects as $id => $body) {

            $offsets[$id] = strlen($pdf);

            $pdf .=
                "$id 0 obj\n" .
                "$body\n" .
                "endobj\n";
        }

        /*
         * XREF
         */
        $xrefStart = strlen($pdf);

        $maxId = max(array_keys($objects));

        $pdf .=
            "xref\n" .
            "0 " . ($maxId + 1) . "\n";

        $pdf .=
            "0000000000 65535 f \n";

        for ($i = 1; $i <= $maxId; $i++) {

            $pdf .= isset($offsets[$i])
                ? sprintf(
                    "%010d 00000 n \n",
                    $offsets[$i]
                )
                : "0000000000 00000 f \n";
        }

        /*
         * TRAILER
         */
        $pdf .=
            "trailer\n" .
            "<< /Size " . ($maxId + 1) .
            " /Root 1 0 R >>\n" .
            "startxref\n" .
            "{$xrefStart}\n" .
            "%%EOF";

        /*
         * HEADER
         */
        header(
            'Content-Type: application/pdf'
        );

        header(
            'Content-Disposition: attachment; filename="' .
            $filename .
            '"'
        );

        header(
            'Content-Length: ' .
            strlen($pdf)
        );

        echo $pdf;

        exit;
    }
}