package pages;

import org.openqa.selenium.*;
import org.openqa.selenium.support.ui.*;
import java.time.Duration;
import java.util.List;

public class TransaksiPage {

    private WebDriver driver;
    private WebDriverWait wait;
    private JavascriptExecutor js;

    private static final String URL_LIST   = "http://localhost:8080/transaksi";
    private static final String URL_TAMBAH = "http://localhost:8080/transaksi/tambah";

    // ── LIST PAGE ──
    private By searchInput      = By.id("searchInput");
    private By dateInput        = By.id("dateInput");
    private By resetBtn         = By.xpath("//button[contains(.,'Reset')]");
    private By transaksiBaruBtn = By.xpath("//a[contains(@href,'/transaksi/tambah')]");
    private By countBadge       = By.id("countBadge");
    private By trxTableRows     = By.cssSelector("#trxTable tbody tr[data-id]");
    private By modalOverlay     = By.id("modalDetail");
    private By modalBody        = By.id("modalBodyContent");
    private By modalTutupBtn    = By.xpath("//div[@id='modalDetail']//button[normalize-space()='Tutup']");

    // ── FORM TAMBAH ──
    private By tanggalInput = By.name("tanggal");
    private By backLink     = By.cssSelector(".back-link");
    private By batalBtn     = By.xpath("//a[contains(@class,'btn-ghost') and contains(@href,'/transaksi')]");
    private By addItemBtn   = By.cssSelector(".add-item-btn");
    private By simpanBtn    = By.id("btnSimpan");
    private By sumItems     = By.id("sumItems");
    private By sumQty       = By.id("sumQty");
    private By sumTotal     = By.id("sumTotal");
    private By totalInput   = By.id("totalInput");

    // ── SIDEBAR ──
    private By sidebarTransaksi = By.xpath("//a[@href='/transaksi']");
    private By sidebarProduk    = By.xpath("//a[@href='/produk']");
    private By sidebarDashboard = By.xpath("//a[@href='/dashboard']");

    public TransaksiPage(WebDriver driver) {
        this.driver = driver;
        this.wait   = new WebDriverWait(driver, Duration.ofSeconds(10));
        this.js     = (JavascriptExecutor) driver;
    }

    // ══════════════════════════════════════════════════════════════
    //  NAVIGASI
    // ══════════════════════════════════════════════════════════════

    /** Navigasi langsung ke halaman list transaksi via URL */
    public void goToList() {
        driver.get(URL_LIST);
        waitForPageLoad();
        wait.until(ExpectedConditions.or(
            ExpectedConditions.presenceOfElementLocated(By.id("trxTable")),
            ExpectedConditions.presenceOfElementLocated(By.id("emptyRow"))
        ));
    }

    /** Navigasi langsung ke form tambah transaksi via URL */
    public void goToTambah() {
        driver.get(URL_TAMBAH);
        waitForPageLoad();
        wait.until(ExpectedConditions.presenceOfElementLocated(By.id("itemsContainer")));
    }

    /**
     * Navigasi ke Transaksi via klik sidebar.
     * Dipanggil di @BeforeEach — menunggu redirect login ke dashboard selesai dulu,
     * baru klik menu Transaksi.
     */
    public void navigateToTransaksiViaSidebar() {
        wait.until(ExpectedConditions.urlContains("/dashboard"));
        wait.until(ExpectedConditions.elementToBeClickable(sidebarTransaksi)).click();
        waitForPageLoad();
        wait.until(ExpectedConditions.urlContains("/transaksi"));
    }

    public void clickTransaksiBaru() {
        wait.until(ExpectedConditions.elementToBeClickable(transaksiBaruBtn)).click();
        waitForPageLoad();
        wait.until(ExpectedConditions.presenceOfElementLocated(By.id("itemsContainer")));
    }

    public void clickKembali() {
        wait.until(ExpectedConditions.elementToBeClickable(backLink)).click();
        waitForPageLoad();
    }

    public void clickBatal() {
        wait.until(ExpectedConditions.elementToBeClickable(batalBtn)).click();
        waitForPageLoad();
    }

    public void clickSidebarMenu(String menu) {
        By target = switch (menu.toLowerCase()) {
            case "produk"    -> sidebarProduk;
            case "dashboard" -> sidebarDashboard;
            case "transaksi" -> sidebarTransaksi;
            default          -> By.xpath("//a[@href='/" + menu + "']");
        };
        wait.until(ExpectedConditions.elementToBeClickable(target)).click();
        waitForPageLoad();
    }

    // ══════════════════════════════════════════════════════════════
    //  PENCARIAN & FILTER
    // ══════════════════════════════════════════════════════════════

    public void searchById(String keyword) {
        WebElement el = wait.until(ExpectedConditions.visibilityOfElementLocated(searchInput));
        el.clear();
        el.sendKeys(keyword);
        pause(400);
    }

    /**
     * Filter tanggal via JavaScript.
     * input[type=date] di Chrome tidak reliable dengan sendKeys biasa.
     * @param dateValue format "yyyy-MM-dd"
     */
    public void filterByDate(String dateValue) {
        WebElement el = wait.until(ExpectedConditions.presenceOfElementLocated(dateInput));
        js.executeScript(
            "arguments[0].value = arguments[1];" +
            "arguments[0].dispatchEvent(new Event('change', {bubbles:true}));",
            el, dateValue
        );
        pause(400);
    }

    public void resetFilter() {
        wait.until(ExpectedConditions.elementToBeClickable(resetBtn)).click();
        pause(400);
    }

    // ══════════════════════════════════════════════════════════════
    //  RESULT HELPERS
    // ══════════════════════════════════════════════════════════════

    public int getVisibleRowCount() {
        return (int) driver.findElements(trxTableRows)
                .stream()
                .filter(WebElement::isDisplayed)
                .count();
    }

    /**
     * Cek tanpa WebDriverWait agar tidak block 10 detik saat element tidak ada.
     */
    public boolean isNoResultShown() {
        List<WebElement> els = driver.findElements(By.id("noResultRow"));
        return !els.isEmpty() && els.get(0).isDisplayed();
    }

    public String getCountBadgeText() {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(countBadge)).getText();
    }

    public boolean isRowWithIdVisible(String id) {
        List<WebElement> rows = driver.findElements(
            By.cssSelector("#trxTable tbody tr[data-id='" + id + "']"));
        return !rows.isEmpty() && rows.get(0).isDisplayed();
    }

    // ══════════════════════════════════════════════════════════════
    //  DETAIL MODAL
    // ══════════════════════════════════════════════════════════════

    public void clickDetail(int trxId) {
        By btn = By.xpath("//button[@onclick='lihatDetail(" + trxId + ")']");
        wait.until(ExpectedConditions.elementToBeClickable(btn)).click();
        // Tunggu spinner hilang (teks "Memuat data" tidak ada lagi)
        wait.until(ExpectedConditions.not(
            ExpectedConditions.textToBePresentInElementLocated(modalBody, "Memuat data")
        ));
        pause(300);
    }

    public boolean isModalVisible() {
        List<WebElement> els = driver.findElements(modalOverlay);
        if (els.isEmpty()) return false;
        String cls = els.get(0).getAttribute("class");
        return cls != null && cls.contains("show");
    }

    public String getModalBodyText() {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(modalBody)).getText();
    }

    public void closeModalByButton() {
        wait.until(ExpectedConditions.elementToBeClickable(modalTutupBtn)).click();
        pause(400);
    }

    /**
     * Tutup modal via klik overlay.
     * Listener di HTML: window.addEventListener('click', e => { if (e.target.classList.contains('modal-overlay'))... })
     * Jadi dispatch click ke element modal-overlay itu sendiri.
     */
    public void closeModalByOverlay() {
        WebElement overlay = wait.until(ExpectedConditions.visibilityOfElementLocated(modalOverlay));
        js.executeScript(
            "arguments[0].dispatchEvent(new MouseEvent('click',{bubbles:true,cancelable:true}))",
            overlay
        );
        pause(500);
    }

    // ══════════════════════════════════════════════════════════════
    //  FORM TAMBAH – TANGGAL
    // ══════════════════════════════════════════════════════════════

    /**
     * Isi datetime-local via JavaScript.
     * @param datetimeValue format "yyyy-MM-ddTHH:mm", misal "2026-05-08T10:30"
     */
    public void setTanggal(String datetimeValue) {
        WebElement el = wait.until(ExpectedConditions.presenceOfElementLocated(tanggalInput));
        js.executeScript(
            "arguments[0].value = arguments[1];" +
            "arguments[0].dispatchEvent(new Event('change', {bubbles:true}));",
            el, datetimeValue
        );
        pause(200);
    }

    // ══════════════════════════════════════════════════════════════
    //  FORM TAMBAH – ITEM PRODUK
    // ══════════════════════════════════════════════════════════════

    /**
     * Pilih produk pada baris ke-rowIndex (1-based).
     * Setelah select, tunggu JS isiHarga() + updateStokBadge() selesai.
     */
    public void selectProduct(int rowIndex, String productId) {
        List<WebElement> selects = driver.findElements(By.cssSelector(".produk-select"));
        new Select(selects.get(rowIndex - 1)).selectByValue(productId);
        pause(400);
    }

    /**
     * Set qty via JavaScript agar event oninput di-trigger dengan benar
     * (yang memanggil validasiQty dan hitungTotal).
     */
    public void setQty(int rowIndex, String qty) {
        List<WebElement> qtys = driver.findElements(By.cssSelector(".qty-input"));
        WebElement el = qtys.get(rowIndex - 1);
        js.executeScript(
            "arguments[0].value = arguments[1];" +
            "arguments[0].dispatchEvent(new Event('input', {bubbles:true}));",
            el, qty
        );
        pause(300);
    }

    public void addItemRow() {
        wait.until(ExpectedConditions.elementToBeClickable(addItemBtn)).click();
        pause(300);
    }

    public void deleteItemRow(int rowIndex) {
        List<WebElement> delBtns = driver.findElements(By.cssSelector(".del-btn"));
        delBtns.get(rowIndex - 1).click();
        pause(300);
    }

    public int getItemRowCount() {
        return driver.findElements(By.cssSelector("#itemsContainer .item-row")).size();
    }

    /**
     * Cek apakah error qty pada baris ke-rowIndex (1-based) sedang tampil.
     * Membaca id="row-X" dari item-row, lalu cek id="qty-err-X" apakah punya class "show".
     */
    public boolean isQtyError(int rowIndex) {
        List<WebElement> rows = driver.findElements(By.cssSelector("#itemsContainer .item-row"));
        if (rowIndex > rows.size()) return false;
        String rowId = rows.get(rowIndex - 1).getAttribute("id").replace("row-", "");
        List<WebElement> errEls = driver.findElements(By.id("qty-err-" + rowId));
        if (errEls.isEmpty()) return false;
        String cls = errEls.get(0).getAttribute("class");
        return cls != null && cls.contains("show");
    }

    public String getStokBadgeText(int rowIndex) {
        List<WebElement> rows = driver.findElements(By.cssSelector("#itemsContainer .item-row"));
        if (rowIndex > rows.size()) return "";
        String rowId = rows.get(rowIndex - 1).getAttribute("id").replace("row-", "");
        List<WebElement> badges = driver.findElements(By.id("stok-info-" + rowId));
        return badges.isEmpty() ? "" : badges.get(0).getText();
    }

    /**
     * Selenium 4: getDomAttribute("disabled") → "true" jika disabled, null jika tidak.
     * isEnabled() juga dicek sebagai fallback.
     */
    public boolean isSimpanDisabled() {
        WebElement btn = wait.until(ExpectedConditions.presenceOfElementLocated(simpanBtn));
        return !btn.isEnabled() || "true".equals(btn.getDomAttribute("disabled"));
    }

    public boolean isSimpanEnabled() {
        return !isSimpanDisabled();
    }

    /**
     * Klik tombol Simpan via JS agar tidak throw ElementNotInteractableException
     * ketika button sedang disabled (dipakai di test case TC_20, TC_21).
     */
    public void clickSimpan() {
        WebElement btn = wait.until(ExpectedConditions.presenceOfElementLocated(simpanBtn));
        js.executeScript("arguments[0].click()", btn);
        pause(500);
    }

    public String getSumItems() { return driver.findElement(sumItems).getText(); }
    public String getSumQty()   { return driver.findElement(sumQty).getText(); }
    public String getSumTotal() { return driver.findElement(sumTotal).getText(); }
    public String getTotalInputValue() {
        return driver.findElement(totalInput).getAttribute("value");
    }

    // ══════════════════════════════════════════════════════════════
    //  URL & FLASH HELPERS
    // ══════════════════════════════════════════════════════════════

    public String getCurrentUrl() {
        return driver.getCurrentUrl();
    }

    public boolean isFlashSuccessVisible() {
        List<WebElement> els = driver.findElements(By.cssSelector(".alert-success"));
        return !els.isEmpty() && els.get(0).isDisplayed();
    }

    public boolean isFlashGone() {
        List<WebElement> els = driver.findElements(By.cssSelector(".alert-success"));
        return els.isEmpty() || !els.get(0).isDisplayed();
    }

    public String getClockText() {
        return driver.findElement(By.id("liveClock")).getText();
    }

    // ══════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ══════════════════════════════════════════════════════════════

    private void waitForPageLoad() {
        wait.until(wd ->
            "complete".equals(((JavascriptExecutor) wd).executeScript("return document.readyState"))
        );
    }

    private void pause(long ms) {
        try { Thread.sleep(ms); } catch (InterruptedException ignored) {}
    }
}