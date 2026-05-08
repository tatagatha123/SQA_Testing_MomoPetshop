package pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;
import java.util.List;

public class ProdukPage {

    WebDriver driver;
    WebDriverWait wait;

    public ProdukPage(WebDriver driver) {
        this.driver = driver;
        this.wait = new WebDriverWait(driver, Duration.ofSeconds(10));

        String currentUrl = driver.getCurrentUrl();

        if (!currentUrl.contains("/produk")) {
            driver.get("http://localhost:8080/produk");
            wait.until(ExpectedConditions.urlContains("/produk"));
        }
    }

    // =====================
    // LOCATOR
    // =====================
    By searchInput = By.id("searchInput");
    By btnTambah   = By.cssSelector("a[href='/produk/tambah']");
    By namaProduk  = By.id("nama_produk");
    By harga       = By.id("harga");
    By stok        = By.id("stok");
    By kategori    = By.id("id_kategori");
    By supplier    = By.id("id_supplier");
    By submitBtn   = By.cssSelector("button[type='submit']");
    By productCard = By.cssSelector(".prod-card");
    By emptySearch = By.id("emptySearch");
    By inputFoto   = By.id("foto_produk");

    // =====================
    // SEARCH
    // =====================
    public void search(String keyword) {
        WebElement input = wait.until(
            ExpectedConditions.visibilityOfElementLocated(searchInput)
        );
        input.clear();
        input.sendKeys(keyword);
        try { Thread.sleep(800); } catch (InterruptedException ignored) {}
    }

    // =====================
    // PRODUCT COUNT
    // =====================
    public int getTotalProductCard() {
        List<WebElement> cards = driver.findElements(productCard);
        return (int) cards.stream()
                .filter(WebElement::isDisplayed)
                .count();
    }

    // =====================
    // EMPTY STATE
    // =====================
    public boolean isEmptySearchVisible() {
        try {
            WebElement el = wait.until(
                ExpectedConditions.visibilityOfElementLocated(emptySearch)
            );
            return el.isDisplayed();
        } catch (Exception e) {
            return false;
        }
    }

    // =====================
    // NAVIGASI TAMBAH
    // =====================
    public void clickTambahProduk() {
        wait.until(ExpectedConditions.elementToBeClickable(btnTambah)).click();
        wait.until(ExpectedConditions.urlContains("/produk/tambah"));
    }

    // =====================
    // ISI FORM
    // =====================
    public void isiNama(String nama) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(namaProduk));
        el.clear();
        el.sendKeys(nama);
    }

    public void isiHarga(String hrg) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(harga));
        el.clear();
        el.sendKeys(hrg);
    }

    public void isiStok(String stk) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(stok));
        el.clear();
        el.sendKeys(stk);
    }

    public void pilihKategori(String namaKategori) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(kategori));
        new Select(el).selectByVisibleText(namaKategori);
    }

    public void pilihSupplier(String namaSupplier) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(supplier));
        new Select(el).selectByVisibleText(namaSupplier);
    }

    public void submitForm() {
        wait.until(ExpectedConditions.elementToBeClickable(submitBtn)).click();
    }

    // =====================
    // UPLOAD FOTO
    // =====================
    public void uploadFoto(String filePath) {
        // presenceOfElementLocated karena input file bisa tidak visible (opacity:0)
        WebElement el = wait.until(
            ExpectedConditions.presenceOfElementLocated(inputFoto)
        );
        el.sendKeys(filePath);
        try { Thread.sleep(500); } catch (InterruptedException ignored) {}
    }
}