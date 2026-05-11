package tests;

import base.BaseTestWithLogin;
import org.junit.jupiter.api.Test;
import pages.DashboardPage;

import static org.junit.jupiter.api.Assertions.*;

public class DashboardTest extends BaseTestWithLogin {

    DashboardPage dashboard;

    @Test
    public void dashboardShouldBeDisplayed() {

        dashboard = new DashboardPage(driver);

        assertTrue(dashboard.isOnDashboard());
    }

    @Test
    public void greetingShouldBeVisible() {

        dashboard = new DashboardPage(driver);

        String greeting = dashboard.getGreetingText();

        assertTrue(greeting.contains("Selamat"));
    }

    @Test
    public void totalProdukShouldAppear() {

        dashboard = new DashboardPage(driver);

        assertTrue(dashboard.pageContains("Total Produk"));
    }

    @Test
    public void totalTransaksiShouldAppear() {

        dashboard = new DashboardPage(driver);

        assertTrue(dashboard.pageContains("Total Transaksi"));
    }

    @Test
    public void totalPendapatanShouldAppear() {

        dashboard = new DashboardPage(driver);

        assertTrue(dashboard.pageContains("Total Pendapatan"));
    }

    @Test
    public void produkMenuShouldWork() {

        dashboard = new DashboardPage(driver);

        dashboard.clickProduk();

        assertTrue(driver.getCurrentUrl().contains("produk"));
    }

    @Test
    public void transaksiMenuShouldWork() {

        dashboard = new DashboardPage(driver);

        dashboard.clickTransaksi();

        assertTrue(driver.getCurrentUrl().contains("transaksi"));
    }

    @Test
    public void stokMasukShouldWork() {

        dashboard = new DashboardPage(driver);

        dashboard.clickStokMasuk();

        assertTrue(driver.getCurrentUrl().contains("stok-masuk"));
    }

    @Test
    public void userMenuShouldWork() {

        dashboard = new DashboardPage(driver);

        dashboard.clickUser();

        assertTrue(driver.getCurrentUrl().contains("user"));
    }

    @Test
    public void laporanMenuShouldWork() {

        dashboard = new DashboardPage(driver);

        dashboard.clickLaporan();

        assertTrue(driver.getCurrentUrl().contains("laporan"));
    }

    @Test
    public void lihatSemuaTransaksiShouldWork() {

        dashboard = new DashboardPage(driver);

        dashboard.clickLihatSemuaTransaksi();

        assertTrue(driver.getCurrentUrl().contains("transaksi"));
    }

    @Test
    public void logoutShouldWork() {

        dashboard = new DashboardPage(driver);

        dashboard.logout();

        assertTrue(driver.getCurrentUrl().contains("login"));
    }

    @Test
    public void dashboardToLogoutShouldRedirectToLogin() {

    dashboard = new DashboardPage(driver);

    // dari dashboard klik logout
    dashboard.logout();

    // harus langsung ke login page
    assertTrue(driver.getCurrentUrl().contains("login"));
    }
}