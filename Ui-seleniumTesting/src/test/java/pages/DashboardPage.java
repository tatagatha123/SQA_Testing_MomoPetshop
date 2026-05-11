package pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

public class DashboardPage {

    WebDriver driver;

    public DashboardPage(WebDriver driver) {
        this.driver = driver;
    }

    // ===== LOCATORS =====
    By greeting = By.id("greeting");

    By menuProduk = By.xpath("//a[contains(.,'Produk')]");
    By menuTransaksi = By.xpath("//a[contains(.,'Transaksi')]");
    By menuStokMasuk = By.xpath("//a[contains(.,'Stok Masuk')]");
    By menuUser = By.xpath("//a[contains(.,'User')]");
    By menuLaporan = By.xpath("//a[contains(.,'Laporan')]");

    By lihatSemuaTransaksi = By.xpath("//a[contains(.,'Lihat semua')]");
    By logoutBtn = By.xpath("//a[contains(.,'Logout')]");

    // ===== ACTIONS =====

    public String getGreetingText() {
        return driver.findElement(greeting).getText();
    }

    public void clickProduk() {
        driver.findElement(menuProduk).click();
    }

    public void clickTransaksi() {
        driver.findElement(menuTransaksi).click();
    }

    public void clickStokMasuk() {
        driver.findElement(menuStokMasuk).click();
    }

    public void clickUser() {
        driver.findElement(menuUser).click();
    }

    public void clickLaporan() {
        driver.findElement(menuLaporan).click();
    }

    public void clickLihatSemuaTransaksi() {
        driver.findElement(lihatSemuaTransaksi).click();
    }

    public void logout() {
        driver.findElement(logoutBtn).click();
    }

    // ===== VALIDATION HELPERS =====

    public boolean isOnDashboard() {
        return driver.getCurrentUrl().contains("dashboard");
    }

    public boolean pageContains(String text) {
        return driver.getPageSource().contains(text);
    }
}