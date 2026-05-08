package tests;

import base.BaseTestWithLogin;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import pages.StokMasukPage;

import static org.junit.jupiter.api.Assertions.*;

public class StokMasukTest extends BaseTestWithLogin {

    private StokMasukPage stokMasukPage;

    @BeforeEach
    public void initPage() {
        stokMasukPage = new StokMasukPage(driver);
    }

    // ═══════════════════════════════════════════════════════════════
    // NAVIGASI
    // ═══════════════════════════════════════════════════════════════

    @Test
    public void testNavSidebar() {
        stokMasukPage.clickNavStokMasuk();
        assertTrue(stokMasukPage.isOnIndexPage());
        assertTrue(stokMasukPage.getPageTitle().toLowerCase().contains("stok masuk"));
    }


    @Test
    public void testTombolTambah() {
        stokMasukPage.openIndexPage();
        stokMasukPage.clickTambahStok();
        assertTrue(stokMasukPage.isOnCreatePage());
    }

    @Test
    public void testTombolKembaliCreate() {
        stokMasukPage.openCreatePage();
        stokMasukPage.clickKembali();
        assertTrue(stokMasukPage.isOnIndexPage());
    }

    // ═══════════════════════════════════════════════════════════════
    // SEARCH
    // ═══════════════════════════════════════════════════════════════

    @Test
    public void testCariProdukAda() {
        stokMasukPage.openIndexPage();
        String nama = stokMasukPage.getCellText(0, 1).split("\n")[0];
        stokMasukPage.search(nama);
        assertTrue(stokMasukPage.isTableContains(nama));
    }

    @Test
    public void testCariSupplierAda() {
        stokMasukPage.openIndexPage();
        String supplier = stokMasukPage.getCellText(0, 2).trim();
        stokMasukPage.search(supplier);
        assertTrue(stokMasukPage.getVisibleRowCount() >= 1);
    }

    @Test
    public void testCariDataTidakAda() {
        stokMasukPage.openIndexPage();
        stokMasukPage.search("xxxDataTidakAdaXyz999");
        assertEquals(0, stokMasukPage.getVisibleRowCount());
    }

    @Test
    public void testClearSearch() {
        stokMasukPage.openIndexPage();
        int total = stokMasukPage.getVisibleRowCount();
        stokMasukPage.search("xxxTidakAda");
        stokMasukPage.clearSearch();
        assertEquals(total, stokMasukPage.getVisibleRowCount());
    }

    // ═══════════════════════════════════════════════════════════════
    // TAMBAH STOK — POSITIF
    // ═══════════════════════════════════════════════════════════════

    @Test
    public void testTambahValid() {
        stokMasukPage.openCreatePage();
        stokMasukPage.selectProdukByIndex(1);
        stokMasukPage.selectSupplierByIndex(1);
        stokMasukPage.setJumlah("10");
        stokMasukPage.setTanggal("2025-01-15");
        stokMasukPage.clickSimpan();
        assertTrue(stokMasukPage.isSuccessAlertVisible());
    }

    @Test
    public void testTambahJumlahBesar() {
        stokMasukPage.openCreatePage();
        stokMasukPage.selectProdukByIndex(1);
        stokMasukPage.selectSupplierByIndex(1);
        stokMasukPage.setJumlah("9999");
        stokMasukPage.setTanggal("2025-06-01");
        stokMasukPage.clickSimpan();
        assertTrue(stokMasukPage.isSuccessAlertVisible());
    }


    @Test
    public void testTambahTanggalHariIni() {
        stokMasukPage.openCreatePage();
        String today = java.time.LocalDate.now().toString();
        stokMasukPage.selectProdukByIndex(1);
        stokMasukPage.selectSupplierByIndex(1);
        stokMasukPage.setJumlah("5");
        stokMasukPage.setTanggal(today);
        stokMasukPage.clickSimpan();
        assertTrue(stokMasukPage.isSuccessAlertVisible());
    }

    // ═══════════════════════════════════════════════════════════════
    // TAMBAH STOK — NEGATIF
    // ═══════════════════════════════════════════════════════════════

    @Test
    public void testTambahTanpaProduk() {
        stokMasukPage.openCreatePage();
        stokMasukPage.selectSupplierByIndex(1);
        stokMasukPage.setJumlah("5");
        stokMasukPage.setTanggal("2025-01-15");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
        assertTrue(stokMasukPage.isOnCreatePage() || stokMasukPage.isErrorAlertVisible());
    }

    @Test
    public void testTambahTanpaSupplier() {
        stokMasukPage.openCreatePage();
        stokMasukPage.selectProdukByIndex(1);
        stokMasukPage.setJumlah("5");
        stokMasukPage.setTanggal("2025-01-15");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
        assertTrue(stokMasukPage.isOnCreatePage() || stokMasukPage.isErrorAlertVisible());
    }

    @Test
    public void testTambahJumlahNol() {
        stokMasukPage.openCreatePage();
        stokMasukPage.selectProdukByIndex(1);
        stokMasukPage.selectSupplierByIndex(1);
        stokMasukPage.setJumlah("0");
        stokMasukPage.setTanggal("2025-01-15");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
    }

    @Test
    public void testTambahJumlahNegatif() {
        stokMasukPage.openCreatePage();
        stokMasukPage.selectProdukByIndex(1);
        stokMasukPage.selectSupplierByIndex(1);
        stokMasukPage.setJumlah("-5");
        stokMasukPage.setTanggal("2025-01-15");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
    }

    @Test
    public void testTambahJumlahHuruf() {
        stokMasukPage.openCreatePage();
        stokMasukPage.selectProdukByIndex(1);
        stokMasukPage.selectSupplierByIndex(1);
        stokMasukPage.setJumlah("abc");
        stokMasukPage.setTanggal("2025-01-15");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
    }

    @Test
    public void testTambahTanpaTanggal() {
        stokMasukPage.openCreatePage();
        stokMasukPage.selectProdukByIndex(1);
        stokMasukPage.selectSupplierByIndex(1);
        stokMasukPage.setJumlah("10");
        stokMasukPage.setTanggal("");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
    }

    @Test
    public void testTambahFormKosong() {
        stokMasukPage.openCreatePage();
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
        assertTrue(stokMasukPage.isOnCreatePage() || stokMasukPage.isErrorAlertVisible());
    }

    // ═══════════════════════════════════════════════════════════════
    // EDIT STOK — POSITIF
    // ═══════════════════════════════════════════════════════════════

    @Test
    public void testKlikEdit() {
        stokMasukPage.openIndexPage();
        stokMasukPage.clickEditOnRow(0);
        assertTrue(stokMasukPage.isOnEditPage());
    }

    @Test
    public void testEditDataTerisi() {
        stokMasukPage.openIndexPage();
        stokMasukPage.clickEditOnRow(0);
        assertFalse(stokMasukPage.getJumlahFieldValue().isEmpty());
        assertFalse(stokMasukPage.getTanggalFieldValue().isEmpty());
        assertFalse(stokMasukPage.getSelectedProduk().contains("— Pilih Produk —"));
        assertFalse(stokMasukPage.getSelectedSupplier().contains("— Pilih Supplier —"));
    }


    // ═══════════════════════════════════════════════════════════════
    // EDIT STOK — NEGATIF
    // ═══════════════════════════════════════════════════════════════

    @Test
    public void testEditJumlahNol() {
        stokMasukPage.openIndexPage();
        stokMasukPage.clickEditOnRow(0);
        stokMasukPage.setJumlah("0");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
    }

    @Test
    public void testEditJumlahNegatif() {
        stokMasukPage.openIndexPage();
        stokMasukPage.clickEditOnRow(0);
        stokMasukPage.setJumlah("-10");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
    }

    @Test
    public void testEditProdukKosong() {
        stokMasukPage.openIndexPage();
        stokMasukPage.clickEditOnRow(0);
        stokMasukPage.selectProduk("— Pilih Produk —");
        stokMasukPage.clickSimpan();
        assertFalse(stokMasukPage.isSuccessAlertVisible());
    }

    // ═══════════════════════════════════════════════════════════════
    // HAPUS STOK — POSITIF
    // ═══════════════════════════════════════════════════════════════

    @Test
    public void testModalHapusMuncul() {
        stokMasukPage.openIndexPage();
        stokMasukPage.clickHapusOnRow(0);
        assertTrue(stokMasukPage.isModalVisible());
    }

    @Test
    public void testModalTampilNamaProduk() {
        stokMasukPage.openIndexPage();
        String nama = stokMasukPage.getCellText(0, 1).split("\n")[0];
        stokMasukPage.clickHapusOnRow(0);
        assertTrue(stokMasukPage.getModalDescText().contains(nama));
    }

    @Test
    public void testKonfirmasiHapus() {
        stokMasukPage.openIndexPage();
        int total = stokMasukPage.getVisibleRowCount();
        stokMasukPage.clickHapusOnRow(0);
        stokMasukPage.confirmHapus();
        assertTrue(stokMasukPage.isSuccessAlertVisible());
        assertEquals(total - 1, stokMasukPage.getVisibleRowCount());
    }

    // ═══════════════════════════════════════════════════════════════
    // HAPUS STOK — NEGATIF
    // ═══════════════════════════════════════════════════════════════

    @Test
    public void testBatalHapus() {
        stokMasukPage.openIndexPage();
        int total = stokMasukPage.getVisibleRowCount();
        stokMasukPage.clickHapusOnRow(0);
        stokMasukPage.cancelHapus();
        assertFalse(stokMasukPage.isModalVisible());
        assertEquals(total, stokMasukPage.getVisibleRowCount());
    }

}