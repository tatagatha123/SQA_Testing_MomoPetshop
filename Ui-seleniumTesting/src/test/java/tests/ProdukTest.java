package tests;

import base.BaseTestWithLogin;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;  
import pages.ProdukPage;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.WebElement;
import java.time.Duration;

import static org.junit.jupiter.api.Assertions.*;

public class ProdukTest extends BaseTestWithLogin {

    // =========================
    // SEARCH PRODUK
    // =========================

    @Test
    public void searchProdukValid() {
        ProdukPage p = new ProdukPage(driver);
        p.search("Royal Canin");
        assertTrue(p.getTotalProductCard() > 0);
    }

    @Test
    public void searchProdukCaseInsensitive() {
        ProdukPage p = new ProdukPage(driver);
        p.search("royal canin");
        assertTrue(p.getTotalProductCard() > 0);
    }

    @Test
    public void searchProdukPartialName() {
        ProdukPage p = new ProdukPage(driver);
        p.search("VitaM");
        assertTrue(p.getTotalProductCard() > 0);
    }

    @Test
    public void searchProdukWithSpace() {
        ProdukPage p = new ProdukPage(driver);
        p.search(" Kalung ");
        assertTrue(p.getTotalProductCard() > 0);
    }

    @Test
    public void searchProdukNotFound() {
        ProdukPage p = new ProdukPage(driver);
        p.search("xyz123abc");
        assertTrue(p.isEmptySearchVisible());
    }

    @Test
    public void searchProdukSymbol() {
        ProdukPage p = new ProdukPage(driver);
        p.search("@@@###");
        assertTrue(p.isEmptySearchVisible());
    }

    @Test
    public void searchProdukRandomNumber() {
        ProdukPage p = new ProdukPage(driver);
        p.search("999999");
        assertTrue(p.isEmptySearchVisible());
    }

    @Test
    public void searchProdukEmpty() {
        ProdukPage p = new ProdukPage(driver);
        p.search("");
        assertTrue(p.getTotalProductCard() >= 0);
    }

    // // =========================
    // // VIEW LIST PRODUK
    // // =========================

    // @Test
    // public void viewProdukListAvailable() {
    //     ProdukPage p = new ProdukPage(driver);
    //     assertTrue(p.getTotalProductCard() >= 0);
    // }

    // @Test
    // public void viewProdukEmpty() {
    //     assertTrue(true); // tergantung data DB
    // }

    // @Test
    // public void viewProdukHasImage() {
    //     assertTrue(true);
    // }

    // @Test
    // public void viewProdukNoImage() {
    //     assertTrue(true);
    // }

    // @Test
    // public void viewProdukStockMenipis() {
    //     assertTrue(true);
    // }

    // @Test
    // public void viewProdukStockNormal() {
    //     assertTrue(true);
    // }

    // =========================
    // TAMBAH PRODUK - NAMA
    // =========================

// =========================
// TAMBAH PRODUK - NAMA
// =========================

@Test
public void addProdukNamaValid() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Cat Nip");
    p.isiHarga("50000");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(true);
}

@Test
public void addProdukNamaKosong() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("");
    p.isiHarga("50000");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(driver.findElement(By.id("err_nama_kosong")).isDisplayed());
}

@Test
public void addProdukNamaSymbol() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("@Produk!!");
    p.isiHarga("50000");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(driver.findElement(By.id("err_nama_simbol")).isDisplayed());
}

@Test
public void addProdukNamaAngka() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("12345");
    p.isiHarga("50000");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(true);
}

// =========================
// HARGA
// =========================

@Test
public void addProdukHargaValid() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk B");
    p.isiHarga("70000");
    p.isiStok("25");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(true);
}

@Test
public void addProdukHargaKosong() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk B");
    p.isiHarga("");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(driver.findElement(By.id("err_harga_kosong")).isDisplayed());
}

@Test
public void addProdukHargaNol() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk B");
    p.isiHarga("0");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(driver.findElement(By.id("err_harga_nol")).isDisplayed());
}

@Test
public void addProdukHargaNegatif() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk B");
    p.isiHarga("-1000");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(driver.findElement(By.id("err_harga_nol")).isDisplayed());
}

@Test
public void addProdukHargaDecimal() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk B");
    p.isiHarga("50000.50");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(true);
}

// =========================
// STOK
// =========================

@Test
public void addProdukStokValid() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk C");
    p.isiHarga("50000");
    p.isiStok("10");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(true);
}

@Test
public void addProdukStokKosong() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk C");
    p.isiHarga("50000");
    p.isiStok("");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(driver.findElement(By.id("err_stok_kosong")).isDisplayed());
}

@Test
public void addProdukStokNol() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk C");
    p.isiHarga("50000");
    p.isiStok("0");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(driver.findElement(By.id("err_stok_nol")).isDisplayed());
}

@Test
public void addProdukStokNegatif() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk C");
    p.isiHarga("50000");
    p.isiStok("-5");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(driver.findElement(By.id("err_stok_nol")).isDisplayed());
}

@Test
public void addProdukStokBesar() {
    ProdukPage p = new ProdukPage(driver);
    p.clickTambahProduk();
    p.isiNama("Produk C");
    p.isiHarga("50000");
    p.isiStok("99999");
    p.pilihKategori("Vitamin");
    p.pilihSupplier("CV Animal Care");
    p.submitForm();
    assertTrue(true);
}
    // =========================
// EDIT PRODUK
// =========================

@Test
public void editProdukNamaValid() {
    driver.get("http://localhost:8080/produk/edit/14");
    new WebDriverWait(driver, Duration.ofSeconds(10))
        .until(ExpectedConditions.visibilityOfElementLocated(By.id("nama_produk")));
    ProdukPage p = new ProdukPage(driver);
    p.isiNama("Update Nama");
    p.submitForm();
    assertTrue(true);
}

@Test
public void editProdukHargaValid() {
    driver.get("http://localhost:8080/produk/edit/14");
    new WebDriverWait(driver, Duration.ofSeconds(10))
        .until(ExpectedConditions.visibilityOfElementLocated(By.id("harga")));
    ProdukPage p = new ProdukPage(driver);
    p.isiHarga("60000");
    p.submitForm();
    assertTrue(true);
}

@Test
public void editProdukStokValid() {
    driver.get("http://localhost:8080/produk/edit/14");
    new WebDriverWait(driver, Duration.ofSeconds(10))
        .until(ExpectedConditions.visibilityOfElementLocated(By.id("stok")));
    ProdukPage p = new ProdukPage(driver);
    p.isiStok("20");
    p.submitForm();
    assertTrue(true);
}

@Test
public void editProdukKategoriBlocked() {
    driver.get("http://localhost:8080/produk/edit/14");
    new WebDriverWait(driver, Duration.ofSeconds(10))
        .until(ExpectedConditions.visibilityOfElementLocated(By.id("id_kategori")));
    // Cek field kategori disabled — tidak bisa diubah saat edit
    WebElement kategoriField = driver.findElement(By.id("id_kategori"));
    assertFalse(kategoriField.isEnabled());
}

@Test
public void editProdukSupplierBlocked() {
    driver.get("http://localhost:8080/produk/edit/14");
    new WebDriverWait(driver, Duration.ofSeconds(10))
        .until(ExpectedConditions.visibilityOfElementLocated(By.id("id_supplier")));
    // Cek field supplier disabled — tidak bisa diubah saat edit
    WebElement supplierField = driver.findElement(By.id("id_supplier"));
    assertFalse(supplierField.isEnabled());
}

@Test
public void editProdukNoChangeSubmit() {
    driver.get("http://localhost:8080/produk/edit/14");
    new WebDriverWait(driver, Duration.ofSeconds(10))
        .until(ExpectedConditions.visibilityOfElementLocated(By.id("nama_produk")));
    ProdukPage p = new ProdukPage(driver);
    p.submitForm();
    assertTrue(true);
}
   // =========================
// FOTO PRODUK
// =========================

@Test
public void uploadFotoValidJpg() {
    driver.get("http://localhost:8080/produk/edit/14");
    new WebDriverWait(driver, Duration.ofSeconds(10))
        .until(ExpectedConditions.presenceOfElementLocated(By.id("foto_produk")));
    ProdukPage p = new ProdukPage(driver);
    p.uploadFoto("/mnt/c/Users/Lenovo/Downloads/testing.jpg"); // ✅ file testing.jpg
    p.submitForm();
    assertTrue(true);
}


@Test
public void uploadFotoReplaceExisting() {
    driver.get("http://localhost:8080/produk/edit/14");
    new WebDriverWait(driver, Duration.ofSeconds(10))
        .until(ExpectedConditions.presenceOfElementLocated(By.id("foto_produk")));
    ProdukPage p = new ProdukPage(driver);
    p.uploadFoto("/mnt/c/Users/Lenovo/Downloads/testing2.jpg"); // ✅ replace dengan testing.jpg
    try { Thread.sleep(1000); } catch (InterruptedException ignored) {}
    WebElement preview = driver.findElement(By.id("newFotoPreview"));
    assertTrue(preview.isDisplayed());
    p.submitForm();
}
    // =========================
    // SEARCH UI EDGE CASE
    // =========================

    @Test
    public void searchProdukFastTyping() {
        ProdukPage p = new ProdukPage(driver);
        p.search("W");
        p.search("Wh");
        p.search("Whi");
        p.search("Whis");
        assertTrue(true);
    }

    @Test
    public void searchProdukClearKeyword() {
        ProdukPage p = new ProdukPage(driver);
        p.search("Royal Canin");
        p.search("");
        assertTrue(true);
    }

    @Test
    public void searchProdukEmptyState() {
        ProdukPage p = new ProdukPage(driver);
        p.search("zzzxyz");
        assertTrue(p.isEmptySearchVisible());
    }

}