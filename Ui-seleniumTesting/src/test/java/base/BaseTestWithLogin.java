package base;

import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.AfterEach;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import pages.LoginPage;

public class BaseTestWithLogin {

    protected WebDriver driver;

    @BeforeEach
    public void setUp() {

        driver = new ChromeDriver();
        driver.manage().window().maximize();

        driver.get("http://localhost:8080/login");

        LoginPage login = new LoginPage(driver);
        login.login("admin", "123456");
    }
     @AfterEach
    public void tearDown() {

        try {
            Thread.sleep(4000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }

        if (driver != null) {
            driver.quit();
        }
    }
}