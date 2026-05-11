package test;

import base.BaseTestWithLogin;
import org.junit.jupiter.api.*;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import pages.TransaksiPage;

import static org.junit.jupiter.api.Assertions.*;

public class TransaksiTest extends BaseTestWithLogin {

    private TransaksiPage trxPage;

    // ── TEST DATA ─────────────────────────────────────────────────
    private static final String EXISTING_TRX_ID    = "1";
    private static final String NONEXISTENT_TRX_ID = "99999";
    private static final String EXISTING_DATE       = "2026-05-07";
    private static final String NONEXISTENT_DATE    = "2000-01-01";
    private static final String PRODUCT_ID_1        = "1";
    private static final String PRODUCT_ID_2        = "2";
    private static final String PRODUCT_ID_NO_STOCK = "3";
    private static final String PRODUCT_1_MAX_STOCK = "10";
    private static final String QTY_EXCEED_STOCK    = "9999";
    private static final String VALID_DATETIME      = "2026-05-08T10:30";
    // ─────────────────────────────────────────────────────────────

    @BeforeEach
    public void initPage() {
        trxPage = new TransaksiPage(driver);
        trxPage.navigateToTransaksiViaSidebar();
    }

    // =========================
    // SEARCH TRANSAKSI
    // =========================


    @Test
    public void searchByIdValid() {
        trxPage.searchById("1");
        assertTrue(trxPage.getVisibleRowCount() >= 1);
        assertFalse(trxPage.isNoResultShown());
    }

    @Test
    public void searchByIdNotFound() {
        trxPage.searchById(NONEXISTENT_TRX_ID);
        assertEquals(0, trxPage.getVisibleRowCount());
        assertTrue(trxPage.isNoResultShown());
    }

    @Test
    public void searchByIdSpecialChar() {
        trxPage.searchById("#@!");
        assertEquals(0, trxPage.getVisibleRowCount());
        assertTrue(trxPage.isNoResultShown());
    }

    @Test
    public void searchByIdAsterisk() {
        trxPage.searchById("*");
        assertEquals(0, trxPage.getVisibleRowCount());
        assertTrue(trxPage.isNoResultShown());
    }

    @Test
    public void searchResetFilter() {
        int totalAwal = trxPage.getVisibleRowCount();
        trxPage.searchById(NONEXISTENT_TRX_ID);
        assertEquals(0, trxPage.getVisibleRowCount());
        trxPage.resetFilter();
        assertEquals(totalAwal, trxPage.getVisibleRowCount());
        assertFalse(trxPage.isNoResultShown());
    }

    // =========================
    // FILTER TANGGAL
    // =========================

    @Test
    public void filterByDateValid() {
        trxPage.filterByDate(EXISTING_DATE);
        assertTrue(trxPage.getVisibleRowCount() >= 1);
        assertFalse(trxPage.isNoResultShown());
    }

    @Test
    public void filterByDateAndIdValid() {
        trxPage.searchById(EXISTING_TRX_ID);
        trxPage.filterByDate(EXISTING_DATE);
        assertTrue(trxPage.getVisibleRowCount() >= 1);
        assertTrue(trxPage.isRowWithIdVisible(EXISTING_TRX_ID));
    }

    @Test
    public void filterByDateNotFound() {
        trxPage.filterByDate(NONEXISTENT_DATE);
        assertEquals(0, trxPage.getVisibleRowCount());
        assertTrue(trxPage.isNoResultShown());
    }

    @Test
    public void filterByIdValidDateMismatch() {
        trxPage.searchById(EXISTING_TRX_ID);
        trxPage.filterByDate(NONEXISTENT_DATE);
        assertEquals(0, trxPage.getVisibleRowCount());
        assertTrue(trxPage.isNoResultShown());
    }

    // =========================
    // DETAIL MODAL
    // =========================

    @Test
    public void openDetailModal() {
        trxPage.clickDetail(Integer.parseInt(EXISTING_TRX_ID));
        assertTrue(trxPage.isModalVisible());
        String body = trxPage.getModalBodyText();
        assertFalse(body.contains("Memuat data"));
        assertTrue(body.length() > 20);
    }

    @Test
    public void closeDetailModalByButton() {
        trxPage.clickDetail(Integer.parseInt(EXISTING_TRX_ID));
        assertTrue(trxPage.isModalVisible());
        trxPage.closeModalByButton();
        assertFalse(trxPage.isModalVisible());
    }

    @Test
    public void closeDetailModalByOverlay() {
        trxPage.clickDetail(Integer.parseInt(EXISTING_TRX_ID));
        assertTrue(trxPage.isModalVisible());
        trxPage.closeModalByOverlay();
        assertFalse(trxPage.isModalVisible());
    }

    // =========================
    // NAVIGASI
    // =========================

    @Test
    public void clickTransaksiBaru() {
        trxPage.clickTransaksiBaru();
        assertTrue(trxPage.getCurrentUrl().contains("/transaksi/tambah"));
    }

    @Test
    public void clickKembaliFromForm() {
        trxPage.goToTambah();
        trxPage.clickKembali();
        String url = trxPage.getCurrentUrl();
        assertTrue(url.contains("/transaksi"));
        assertFalse(url.contains("/tambah"));
    }

    @Test
    public void clickBatalFromForm() {
        trxPage.goToTambah();
        trxPage.clickBatal();
        String url = trxPage.getCurrentUrl();
        assertTrue(url.contains("/transaksi"));
        assertFalse(url.contains("/tambah"));
    }

    // =========================
    // FORM TAMBAH - TANGGAL
    // =========================

    @Test
    public void fillTanggalValid() {
        trxPage.goToTambah();
        trxPage.setTanggal(VALID_DATETIME);
        assertTrue(driver.findElements(By.cssSelector(".is-error")).isEmpty());
    }

    // =========================
    // FORM TAMBAH - ITEM PRODUK
    // =========================

    @Test
    public void selectProductAutoFillHarga() {
        trxPage.goToTambah();
        trxPage.selectProduct(1, PRODUCT_ID_1);
        String harga = driver.findElements(By.cssSelector(".harga-input"))
                             .get(0).getAttribute("value");
        assertFalse(harga.isEmpty());
        assertNotEquals("0", harga);
        assertFalse(trxPage.getStokBadgeText(1).contains("Pilih produk dahulu"));
    }

    @Test
    public void fillQtyValid() {
        trxPage.goToTambah();
        trxPage.selectProduct(1, PRODUCT_ID_1);
        trxPage.setQty(1, PRODUCT_1_MAX_STOCK);
        assertFalse(trxPage.isQtyError(1));
        assertTrue(trxPage.isSimpanEnabled());
    }


    @Test
    public void addMultipleItemsValid() {
        trxPage.goToTambah();
        trxPage.selectProduct(1, PRODUCT_ID_1);
        trxPage.setQty(1, "1");
        trxPage.addItemRow();
        trxPage.selectProduct(2, PRODUCT_ID_2);
        trxPage.setQty(2, "1");
        assertFalse(trxPage.isQtyError(1));
        assertFalse(trxPage.isQtyError(2));
        assertTrue(trxPage.isSimpanEnabled());
        assertEquals("2", trxPage.getSumItems());
    }

    @Test
    public void deleteItemRow() {
        trxPage.goToTambah();
        trxPage.addItemRow();
        int before = trxPage.getItemRowCount();
        trxPage.deleteItemRow(2);
        assertEquals(before - 1, trxPage.getItemRowCount());
    }

    @Test
    public void fillQtyExceedStock() {
        trxPage.goToTambah();
        trxPage.selectProduct(1, PRODUCT_ID_1);
        trxPage.setQty(1, QTY_EXCEED_STOCK);
        assertTrue(trxPage.isQtyError(1));
        assertTrue(trxPage.isSimpanDisabled());
    }

    @Test
    public void selectProductOutOfStock() {
        trxPage.goToTambah();
        trxPage.selectProduct(1, PRODUCT_ID_NO_STOCK);
        String badge = trxPage.getStokBadgeText(1);
        assertTrue(badge.contains("Stok habis"));
        assertTrue(trxPage.isQtyError(1));
        assertTrue(trxPage.isSimpanDisabled());
    }


    @Test
    public void fillQtyZero() {
        trxPage.goToTambah();
        trxPage.selectProduct(1, PRODUCT_ID_1);
        trxPage.setQty(1, "0");
        assertTrue(trxPage.isQtyError(1));
        assertTrue(trxPage.isSimpanDisabled());
    }


    // =========================
    // SUBMIT TRANSAKSI
    // =========================

    @Test
    public void submitTransaksiValid() {
        trxPage.goToTambah();
        trxPage.setTanggal(VALID_DATETIME);
        trxPage.selectProduct(1, PRODUCT_ID_1);
        trxPage.setQty(1, "1");
        assertTrue(trxPage.isSimpanEnabled());
        trxPage.clickSimpan();
        String url = trxPage.getCurrentUrl();
        assertTrue(url.contains("/transaksi") && !url.contains("/tambah"));
        assertTrue(trxPage.isFlashSuccessVisible());
    }

    @Test
    public void submitTransaksiTanpaProduct() {
        trxPage.goToTambah();
        trxPage.clickSimpan();
        assertTrue(trxPage.getCurrentUrl().contains("/tambah"));
    }

    @Test
    public void submitTransaksiTanpaQty() {
        trxPage.goToTambah();
        trxPage.selectProduct(1, PRODUCT_ID_1);
        trxPage.setQty(1, "");
        trxPage.clickSimpan();
        assertTrue(trxPage.getCurrentUrl().contains("/tambah"));
    }
}