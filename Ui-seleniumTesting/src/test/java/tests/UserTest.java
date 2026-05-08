package tests;

import base.BaseTestWithLogin;
import pages.UserPage;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

/**
 * Test Suite: Manajemen User — MomoPetshop
 *
 * Prasyarat:
 *  - User sudah login (ditangani BaseTestWithLogin)
 *  - Server berjalan di http://localhost:8080
 *  - Minimal 1 user (selain admin) ada di database untuk test hapus
 *
 * Total: 15 Test Scenario (8 Positive, 7 Negative)
 */
public class UserTest extends BaseTestWithLogin {

    private UserPage userPage;

    @BeforeEach
    public void initPage() {
        userPage = new UserPage(driver);
    }

    // ══════════════════════════════════════════════════════════════════════
    //  POSITIVE TEST CASES
    // ══════════════════════════════════════════════════════════════════════

    /**
     * TC-U-001 | POSITIVE
     * Memastikan halaman daftar user dapat dibuka dan menampilkan tabel.
     */
    @Test
    public void testBukaHalamanUser() {
        userPage.bukaHalamanUser();

        String url = userPage.getCurrentUrl();
        assertTrue(url.contains("/user"),
            "URL harus mengandung /user");

        // Minimal 1 user tampil (admin sendiri)
        assertTrue(userPage.jumlahUserTampil() >= 1,
            "Harus ada minimal 1 user di tabel");
    }

    /**
     * TC-U-002 | POSITIVE
     * Tambah user baru dengan data lengkap dan valid.
     */
    @Test
    public void testTambahUserValid() {
        userPage.bukaFormTambahUser();

        userPage.isiFormUser("userbaru", "rahasia123", "rahasia123");

        // Setelah sukses redirect ke /user dan ada flash success
        assertTrue(userPage.adaAlertSukses() || userPage.getCurrentUrl().contains("/user"),
            "Setelah tambah berhasil, harus ada alert sukses atau redirect ke /user");
    }

    /**
     * TC-U-003 | POSITIVE
     * Cari user berdasarkan nama yang ada di database — harus ditemukan.
     */
    @Test
    public void testCariUserDitemukan() {
        userPage.bukaHalamanUser();

        // Cari dengan kata kunci "admin" yang pasti ada
        userPage.cariUser("admin");

        // Delay singkat untuk JS filter bekerja
        try { Thread.sleep(500); } catch (InterruptedException e) { e.printStackTrace(); }

        assertTrue(userPage.jumlahUserTampilDariDataset("admin") >= 1,
            "User dengan nama 'admin' harus ditemukan");
    }

    /**
     * TC-U-004 | POSITIVE
     * Cari user dengan huruf kecil — filter harus case-insensitive.
     */
    @Test
    public void testCariUserCaseInsensitive() {
        userPage.bukaHalamanUser();

        userPage.cariUser("ADMIN");
        try { Thread.sleep(500); } catch (InterruptedException e) { e.printStackTrace(); }

        assertTrue(userPage.jumlahUserTampilDariDataset("admin") >= 1,
            "Filter harus tetap menemukan 'admin' walau input huruf kapital");
    }

    /**
     * TC-U-005 | POSITIVE
     * Klik tombol Hapus — modal konfirmasi muncul dan menampilkan nama user.
     */
    @Test
    public void testModalHapusMuncul() {
        userPage.bukaHalamanUser();

        userPage.klikHapusUser(0);

        assertTrue(userPage.modalHapusMuncul(),
            "Modal konfirmasi hapus harus muncul setelah klik tombol hapus");

        assertFalse(userPage.getNamaUserDiModal().isEmpty(),
            "Nama user harus tampil di dalam modal konfirmasi");
    }

    /**
     * TC-U-006 | POSITIVE
     * Klik Batal di modal hapus — modal tertutup, user tidak terhapus.
     */
    @Test
    public void testBatalHapusUser() {
        userPage.bukaHalamanUser();

        int jumlahAwal = userPage.jumlahUserTampil();
        userPage.klikHapusUser(0);
        assertTrue(userPage.modalHapusMuncul(), "Modal harus terbuka");

        userPage.batalHapus();
        try { Thread.sleep(500); } catch (InterruptedException e) { e.printStackTrace(); }

        assertTrue(userPage.isModalTertutup(),
            "Modal harus tertutup setelah klik Batal");

        assertEquals(jumlahAwal, userPage.jumlahUserTampil(),
            "Jumlah user tidak boleh berkurang setelah batal hapus");
    }


    /**
     * TC-U-008 | POSITIVE
     * Navigasi ke form tambah user dari tombol di toolbar berhasil.
     */
    @Test
    public void testKlikTambahUser() {
        userPage.bukaHalamanUser();
        userPage.klikTambahUser();

        assertTrue(userPage.getCurrentUrl().contains("/user/create"),
            "URL harus mengarah ke /user/create setelah klik tombol Tambah User");
    }

    // ══════════════════════════════════════════════════════════════════════
    //  NEGATIVE TEST CASES
    // ══════════════════════════════════════════════════════════════════════

    /**
     * TC-U-009 | NEGATIVE
     * Semua field kosong — form tidak boleh berhasil submit.
     */
    @Test
    public void testFormKosongGagal() {
        userPage.bukaFormTambahUser();

        // Tidak isi apapun, langsung submit
        userPage.submit();

        // Harus tetap di halaman create atau ada error
        assertTrue(
            userPage.getCurrentUrl().contains("/user/create") ||
            userPage.adaInvalidFeedback(),
            "Submit form kosong harus menampilkan error atau tetap di halaman form"
        );
    }

    /**
     * TC-U-010 | NEGATIVE
     * Username menggunakan angka saja — seharusnya tidak valid.
     */
    @Test
    public void testUsernameAngkaSajaGagal() {
        userPage.bukaFormTambahUser();

        userPage.isiFormUser("123456", "pass123", "pass123");

        assertTrue(
            userPage.adaInvalidFeedback() || userPage.adaAlertError() ||
            userPage.getCurrentUrl().contains("/user/create"),
            "Username berupa angka saja seharusnya tidak diperbolehkan"
        );
    }

    /**
     * TC-U-011 | NEGATIVE
     * Username menggunakan karakter khusus (bintang, @, #) — harus gagal.
     */
    @Test
    public void testUsernameKarakterKhususGagal() {
        userPage.bukaFormTambahUser();

        userPage.isiFormUser("user@#*!", "pass123", "pass123");

        assertTrue(
            userPage.adaInvalidFeedback() || userPage.adaAlertError() ||
            userPage.getCurrentUrl().contains("/user/create"),
            "Username dengan karakter khusus harus ditolak"
        );
    }


    /**
     * TC-U-013 | NEGATIVE
     * Password dan konfirmasi password tidak cocok — harus gagal.
     */
    @Test
    public void testPasswordTidakCocokGagal() {
        userPage.bukaFormTambahUser();

        userPage.isiFormUser("uservalid", "pass123", "pass456");

        assertTrue(
            userPage.adaInvalidFeedback() || userPage.adaAlertError() ||
            userPage.getCurrentUrl().contains("/user/create"),
            "Jika password dan konfirmasi tidak cocok, form harus ditolak"
        );
    }

    /**
     * TC-U-014 | NEGATIVE
     * Cari user dengan nama yang tidak ada — tidak ada row yang tampil.
     */
    @Test
    public void testCariUserTidakDitemukan() {
        userPage.bukaHalamanUser();

        userPage.cariUser("xxxxnamayangpastisalah9999");
        try { Thread.sleep(500); } catch (InterruptedException e) { e.printStackTrace(); }

        assertEquals(0, userPage.jumlahUserTampilDariDataset("xxxxnamayangpastisalah9999"),
            "Tidak boleh ada user yang tampil untuk keyword yang tidak ada");
    }

    /**
     * TC-U-015 | NEGATIVE
     * Field username kosong, password diisi — form harus gagal.
     */
    @Test
    public void testUsernameKosongGagal() {
        userPage.bukaFormTambahUser();

        // Hanya isi password, username dibiarkan kosong
        userPage.isiPassword("pass123");
        userPage.isiKonfirmasiPassword("pass123");
        userPage.submit();

        assertTrue(
            userPage.adaInvalidFeedback() || userPage.adaAlertError() ||
            userPage.getCurrentUrl().contains("/user/create"),
            "Form harus gagal jika username kosong meskipun password diisi"
        );
    }
}