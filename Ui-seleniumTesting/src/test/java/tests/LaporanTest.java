package tests;

import base.BaseTestWithLogin;
import org.junit.jupiter.api.Test;
import pages.DashboardPage;
import pages.LaporanPage;

import static org.junit.jupiter.api.Assertions.*;

public class LaporanTest extends BaseTestWithLogin {

    DashboardPage dashboard;
    LaporanPage laporan;

    @Test
    public void laporanShouldBeDisplayedAndContainData() {

        dashboard = new DashboardPage(driver);

        dashboard.clickLaporan();

        laporan = new LaporanPage(driver);

        // DEBUG
        System.out.println("CURRENT URL: " + driver.getCurrentUrl());

        assertTrue(laporan.isOnLaporanPage());

        assertTrue(laporan.hasTransactionData());
    }
}