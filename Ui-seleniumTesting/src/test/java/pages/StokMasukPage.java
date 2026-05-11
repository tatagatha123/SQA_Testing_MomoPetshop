package pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;
import java.util.List;

public class StokMasukPage {

    private WebDriver driver;
    private WebDriverWait wait;

    // ── URL ──────────────────────────────────────────────
    private static final String URL_INDEX  = "http://localhost:8080/stok-masuk";
    private static final String URL_CREATE = "http://localhost:8080/stok-masuk/create";

    // ── SIDEBAR NAV ──────────────────────────────────────
    private By navStokMasuk = By.cssSelector("a[href='/stok-masuk']");

    // ── INDEX PAGE ───────────────────────────────────────
    private By searchInput    = By.id("searchInput");
    private By btnTambahStok  = By.cssSelector("a[href='/stok-masuk/create']");
    private By tableRows      = By.cssSelector("#stokTable tbody tr:not(.no-row)");
    private By emptyState     = By.cssSelector(".empty-state");
    private By alertSuccess   = By.cssSelector(".alert-success");
    private By alertError     = By.cssSelector(".alert-error");
    private By pageHeaderStat = By.cssSelector(".stat-mini-val");

    // ── CREATE / EDIT FORM ───────────────────────────────
    private By selectProduk   = By.id("id_produk");
    private By selectSupplier = By.id("id_supplier");
    private By inputJumlah    = By.id("jumlah");
    private By inputTanggal   = By.id("tanggal");
    private By btnSimpan      = By.cssSelector("button[type='submit']");
    private By btnKembali     = By.cssSelector("a.btn-ghost");

    // ── VALIDATION ERRORS ────────────────────────────────
    private By fieldErrors = By.cssSelector(".field-error");

    // ── MODAL HAPUS ──────────────────────────────────────
    private By modalHapus    = By.id("modalHapus");
    private By btnYaHapus    = By.id("btnHapus");
    private By btnBatalHapus = By.cssSelector(".modal-actions .btn-ghost");
    private By modalDesc     = By.id("modalDesc");

    // ── CONSTRUCTOR ──────────────────────────────────────
    public StokMasukPage(WebDriver driver) {
        this.driver = driver;
        this.wait   = new WebDriverWait(driver, Duration.ofSeconds(10));
    }

    // ─────────────────────────────────────────────────────
    // NAVIGASI
    // ─────────────────────────────────────────────────────

    public void clickNavStokMasuk() {
        wait.until(ExpectedConditions.elementToBeClickable(navStokMasuk)).click();
    }

    public void openIndexPage() {
        driver.get(URL_INDEX);
    }

    public void openCreatePage() {
        driver.get(URL_CREATE);
    }

    public void clickTambahStok() {
        wait.until(ExpectedConditions.elementToBeClickable(btnTambahStok)).click();
    }

    public void clickKembali() {
        wait.until(ExpectedConditions.elementToBeClickable(btnKembali)).click();
    }

    // ─────────────────────────────────────────────────────
    // SEARCH
    // ─────────────────────────────────────────────────────

    public void search(String keyword) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(searchInput));
        el.clear();
        el.sendKeys(keyword);
    }

    public void clearSearch() {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(searchInput));
        el.clear();
    }

    // ─────────────────────────────────────────────────────
    // FORM HELPERS
    // ─────────────────────────────────────────────────────

    public void selectProduk(String visibleText) {
        Select sel = new Select(wait.until(ExpectedConditions.visibilityOfElementLocated(selectProduk)));
        sel.selectByVisibleText(visibleText);
    }

    public void selectProdukByIndex(int index) {
        Select sel = new Select(wait.until(ExpectedConditions.visibilityOfElementLocated(selectProduk)));
        sel.selectByIndex(index);
    }

    public void selectSupplier(String visibleText) {
        Select sel = new Select(wait.until(ExpectedConditions.visibilityOfElementLocated(selectSupplier)));
        sel.selectByVisibleText(visibleText);
    }

    public void selectSupplierByIndex(int index) {
        Select sel = new Select(wait.until(ExpectedConditions.visibilityOfElementLocated(selectSupplier)));
        sel.selectByIndex(index);
    }

    public void setJumlah(String value) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(inputJumlah));
        el.clear();
        el.sendKeys(value);
    }

    public void setTanggal(String value) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(inputTanggal));
        el.clear();
        el.sendKeys(value);
    }

    public void clickSimpan() {
        wait.until(ExpectedConditions.elementToBeClickable(btnSimpan)).click();
    }

    public void fillAndSubmitForm(String produkText, String supplierText, String jumlah, String tanggal) {
        selectProduk(produkText);
        selectSupplier(supplierText);
        setJumlah(jumlah);
        setTanggal(tanggal);
        clickSimpan();
    }

    // ─────────────────────────────────────────────────────
    // EDIT
    // ─────────────────────────────────────────────────────

    public void clickEditOnRow(int rowIndex) {
        List<WebElement> rows = driver.findElements(tableRows);
        rows.get(rowIndex).findElement(By.cssSelector("a.btn-ghost")).click();
    }

    public void clickEditById(int idStok) {
        driver.findElement(By.cssSelector("a[href='/stok-masuk/edit/" + idStok + "']")).click();
    }

    // ─────────────────────────────────────────────────────
    // HAPUS / MODAL
    // ─────────────────────────────────────────────────────

    public void clickHapusOnRow(int rowIndex) {
        List<WebElement> rows = driver.findElements(tableRows);
        rows.get(rowIndex).findElement(By.cssSelector("button.btn-red")).click();
    }

    public void confirmHapus() {
        wait.until(ExpectedConditions.visibilityOfElementLocated(modalHapus));
        wait.until(ExpectedConditions.elementToBeClickable(btnYaHapus)).click();
    }

    public void cancelHapus() {
        wait.until(ExpectedConditions.visibilityOfElementLocated(modalHapus));
        wait.until(ExpectedConditions.elementToBeClickable(btnBatalHapus)).click();
    }

    // ─────────────────────────────────────────────────────
    // ASSERTIONS / GETTERS
    // ─────────────────────────────────────────────────────

    public boolean isOnIndexPage() {
        return driver.getCurrentUrl().contains("/stok-masuk")
                && !driver.getCurrentUrl().contains("/create")
                && !driver.getCurrentUrl().contains("/edit");
    }

    public boolean isOnCreatePage() {
        return driver.getCurrentUrl().contains("/stok-masuk/create");
    }

    public boolean isOnEditPage() {
        return driver.getCurrentUrl().matches(".*/stok-masuk/edit/\\d+");
    }

    public boolean isSuccessAlertVisible() {
        try {
            return wait.until(ExpectedConditions.visibilityOfElementLocated(alertSuccess)).isDisplayed();
        } catch (Exception e) { return false; }
    }

    public String getSuccessAlertText() {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(alertSuccess)).getText();
    }

    public boolean isErrorAlertVisible() {
        try {
            return driver.findElement(alertError).isDisplayed();
        } catch (Exception e) { return false; }
    }

    public boolean isEmptyStateVisible() {
        try {
            List<WebElement> els = driver.findElements(emptyState);
            return !els.isEmpty() && els.get(0).isDisplayed();
        } catch (Exception e) { return false; }
    }

    public int getVisibleRowCount() {
        List<WebElement> rows = driver.findElements(tableRows);
        return (int) rows.stream()
                .filter(r -> !r.getCssValue("display").equals("none"))
                .count();
    }

    public boolean isTableContains(String keyword) {
        List<WebElement> rows = driver.findElements(tableRows);
        return rows.stream().anyMatch(r -> r.getText().toLowerCase().contains(keyword.toLowerCase()));
    }

    public boolean isModalVisible() {
        try {
            return driver.findElement(modalHapus).getAttribute("class").contains("show");
        } catch (Exception e) { return false; }
    }

    public String getModalDescText() {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(modalDesc)).getText();
    }

    public String getTotalStokText() {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(pageHeaderStat)).getText();
    }

    public String getPageTitle() {
        return driver.getTitle();
    }

    public boolean isFieldErrorVisible() {
        try {
            List<WebElement> errors = driver.findElements(fieldErrors);
            return !errors.isEmpty();
        } catch (Exception e) { return false; }
    }

    public String getJumlahFieldValue() {
        return driver.findElement(inputJumlah).getAttribute("value");
    }

    public String getTanggalFieldValue() {
        return driver.findElement(inputTanggal).getAttribute("value");
    }

    public String getSelectedProduk() {
        Select sel = new Select(driver.findElement(selectProduk));
        return sel.getFirstSelectedOption().getText();
    }

    public String getSelectedSupplier() {
        Select sel = new Select(driver.findElement(selectSupplier));
        return sel.getFirstSelectedOption().getText();
    }

    public String getCellText(int rowIndex, int colIndex) {
        List<WebElement> rows = driver.findElements(tableRows);
        List<WebElement> cols = rows.get(rowIndex).findElements(By.tagName("td"));
        return cols.get(colIndex).getText().trim();
    }
}