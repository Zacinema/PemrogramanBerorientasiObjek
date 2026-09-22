<?php

interface Bentuk {
    public function hitungLuas(): float;
}

trait InfoBentuk {
    public function tampilkanInfo(): string {
        return sprintf("Bentuk: %s, Luas: %.2f", $this->getNama(), $this->hitungLuas());
    }
}

abstract class BentukDasar implements Bentuk {
    use InfoBentuk;

    protected string $nama;

    public function __construct(string $nama) {
        $this->nama = $nama;
    }

    public function getNama(): string {
        return $this->nama;
    }

    abstract public function hitungLuas(): float;
}

class Persegi extends BentukDasar {
    private float $sisi;

    public function __construct(float $sisi) {
        parent::__construct('Persegi');
        $this->setSisi($sisi);          
    }

    public function getSisi(): float {
        return $this->sisi;
    }

    public function setSisi(float $sisi): void {
        if ($sisi <= 0) {
            throw new InvalidArgumentException('Sisi harus lebih besar dari 0');
        }
        $this->sisi = $sisi;
    }

    public function hitungLuas(): float {
        return $this->sisi * $this->sisi;
    }
}

class Lingkaran extends BentukDasar {
    private const PHI = 3.14;

    private float $radius;

    public function __construct(float $radius) {
        parent::__construct('Lingkaran');
        $this->setRadius($radius);
    }

    public function getRadius(): float {
        return $this->radius;
    }

    public function setRadius(float $radius): void {
        if ($radius <= 0) {
            throw new InvalidArgumentException('Radius harus lebih besar dari 0');
        }
        $this->radius = $radius;
    }

    public function hitungLuas(): float {
        return self::PHI * $this->radius * $this->radius;
    }
}

$daftarBentuk = [
    new Persegi(5),  
    new Lingkaran(7) 
];

foreach ($daftarBentuk as $bentuk) {
    if ($bentuk instanceof Persegi) {
        printf("Luas Persegi (sisi=%.0f): %.0f\n", $bentuk->getSisi(), $bentuk->hitungLuas());
    } elseif ($bentuk instanceof Lingkaran) {
        printf("Luas Lingkaran (radius=%.0f): %.2f\n", $bentuk->getRadius(), $bentuk->hitungLuas());
    }
}

echo "\n--- Info tambahan (dari trait InfoBentuk) ---\n";
foreach ($daftarBentuk as $bentuk) {
    echo $bentuk->tampilkanInfo() . "\n";
}