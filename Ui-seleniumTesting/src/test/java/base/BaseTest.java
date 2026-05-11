package base;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;

public class BaseTest {

    protected WebDriver driver;

    @BeforeEach
    public void setUp() throws InterruptedException {

        ChromeOptions options = new ChromeOptions();

        // khusus WSL/Linux
        options.addArguments("--no-sandbox");
        options.addArguments("--disable-dev-shm-usage");

        driver = new ChromeDriver(options);

        driver.manage().window().maximize();

        // buka halaman login CI4
        driver.get("http://localhost:8083/login");

        // tunggu page load
        Thread.sleep(3000);
    }

    @AfterEach
    public void tearDown() {

        if (driver != null) {

            driver.quit();
        }
    }
}