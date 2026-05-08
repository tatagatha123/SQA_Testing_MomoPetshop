package pages;

import org.openqa.selenium.*;
import org.openqa.selenium.support.ui.*;
import java.time.Duration;

public class UserPage {

    private WebDriver driver;
    private WebDriverWait wait;

    // ── URL ──────────────────────────────────────────────────────────────
    private static final String USER_URL   = "http://localhost:8080/user";
    private static final String CREATE_URL = "http://localhost:8080/user/create";

    // ── Locators: Halaman Daftar User ─────────────────────────────────────
    private By searchInput    = By.id("searchInput");
    private By btnTambahUser  = By.xpath("//a[contains(@href,'/user/create')]");
    private By userTableRows  = By.cssSelector("#userTable tbody tr[data-username]");
    private By btnHapusFirst  = By.cssSelector("#userTable tbody tr[data-username] .btn-red");
    private By modalHapus     = By.id("modalHapus");
    private By modalNamaUser  = By.id("namaUser");
    private By btnKonfirmasiHapus = By.id("linkHapus");
    private By btnBatalModal  = By.xpath("//button[contains(text(),'Batal')]");

    // ── Locators: Form Tambah/Edit User ───────────────────────────────────
    private By inputUsername          = By.name("username");
    private By inputPassword          = By.name("password");
    private By inputKonfirmasiPass    = By.name("konfirmasi_password");
    private By btnSubmit              = By.cssSelector("button[type='submit']");
    private By invalidFeedback        = By.className("invalid-feedback");
    private By alertSuccess           = By.className("alert-success");
    private By alertError             = By.className("alert-error");

    // ── Constructor ───────────────────────────────────────────────────────
    public UserPage(WebDriver driver) {
        this.driver = driver;
        this.wait   = new WebDriverWait(driver, Duration.ofSeconds(10));
    }

    // ── Navigasi ──────────────────────────────────────────────────────────
    public void bukaHalamanUser() {
        driver.get(USER_URL);
    }

    public void bukaFormTambahUser() {
        driver.get(CREATE_URL);
    }

    // ── Aksi: Halaman Daftar User ─────────────────────────────────────────
    public void cariUser(String keyword) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(searchInput));
        el.clear();
        el.sendKeys(keyword);
    }

    public int jumlahUserTampil() {
        try {
            wait.until(ExpectedConditions.presenceOfElementLocated(userTableRows));
            return driver.findElements(userTableRows).stream()
                .filter(r -> !r.getCssValue("display").equals("none"))
                .mapToInt(r -> 1)
                .sum();
        } catch (Exception e) {
            return 0;
        }
    }

    public int jumlahUserTampilDariDataset(String keyword) {
        // Hitung row yang data-username mengandung keyword (case-insensitive)
        return (int) driver.findElements(userTableRows).stream()
            .filter(r -> {
                String attr = r.getAttribute("data-username");
                return attr != null && attr.toLowerCase().contains(keyword.toLowerCase());
            })
            .count();
    }

    public void klikTambahUser() {
        wait.until(ExpectedConditions.elementToBeClickable(btnTambahUser)).click();
    }

    public void klikHapusUser(int index) {
        java.util.List<WebElement> btns = driver.findElements(btnHapusFirst);
        if (index < btns.size()) {
            btns.get(index).click();
        }
    }

    public boolean modalHapusMuncul() {
        try {
            WebElement modal = wait.until(ExpectedConditions.visibilityOfElementLocated(modalHapus));
            return modal.getAttribute("class").contains("show");
        } catch (Exception e) {
            return false;
        }
    }

    public String getNamaUserDiModal() {
        return driver.findElement(modalNamaUser).getText();
    }

    public void konfirmasiHapus() {
        wait.until(ExpectedConditions.elementToBeClickable(btnKonfirmasiHapus)).click();
    }

    public void batalHapus() {
        wait.until(ExpectedConditions.elementToBeClickable(btnBatalModal)).click();
    }

    // ── Aksi: Form Tambah User ────────────────────────────────────────────
    public void isiUsername(String username) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(inputUsername));
        el.clear();
        el.sendKeys(username);
    }

    public void isiPassword(String password) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(inputPassword));
        el.clear();
        el.sendKeys(password);
    }

    public void isiKonfirmasiPassword(String konfirmasi) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(inputKonfirmasiPass));
        el.clear();
        el.sendKeys(konfirmasi);
    }

    public void submit() {
        driver.findElement(btnSubmit).click();
    }

    public void isiFormUser(String username, String password, String konfirmasi) {
        isiUsername(username);
        isiPassword(password);
        isiKonfirmasiPassword(konfirmasi);
        submit();
    }

    // ── Assertions Helper ─────────────────────────────────────────────────
    public boolean adaAlertSukses() {
        try {
            wait.until(ExpectedConditions.visibilityOfElementLocated(alertSuccess));
            return true;
        } catch (Exception e) {
            return false;
        }
    }

    public boolean adaAlertError() {
        try {
            wait.until(ExpectedConditions.visibilityOfElementLocated(alertError));
            return true;
        } catch (Exception e) {
            return false;
        }
    }

    public boolean adaInvalidFeedback() {
        try {
            wait.until(ExpectedConditions.visibilityOfElementLocated(invalidFeedback));
            return true;
        } catch (Exception e) {
            return false;
        }
    }

    public String getInvalidFeedbackText() {
        try {
            return driver.findElement(invalidFeedback).getText();
        } catch (Exception e) {
            return "";
        }
    }

    public boolean isModalTertutup() {
        try {
            WebElement modal = driver.findElement(modalHapus);
            return !modal.getAttribute("class").contains("show");
        } catch (Exception e) {
            return true;
        }
    }

    public String getCurrentUrl() {
        return driver.getCurrentUrl();
    }

    public boolean adaUserDenganNama(String username) {
        return driver.findElements(userTableRows).stream()
            .anyMatch(r -> {
                String attr = r.getAttribute("data-username");
                return attr != null && attr.equalsIgnoreCase(username);
            });
    }
}