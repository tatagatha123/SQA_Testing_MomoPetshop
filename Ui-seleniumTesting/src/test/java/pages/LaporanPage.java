package pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

public class LaporanPage {

    WebDriver driver;

    public LaporanPage(WebDriver driver) {
        this.driver = driver;
    }

    By tableRow = By.xpath("//table//tbody//tr");

    public boolean isOnLaporanPage() {
        return driver.getCurrentUrl().contains("laporan");
    }

    public boolean hasTransactionData() {
        return driver.findElements(tableRow).size() > 0;
    }
}