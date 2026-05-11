package pages;

import java.time.Duration;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

public class LoginPage {

    WebDriver driver;
    WebDriverWait wait;

    // locator
    By usernameField = By.id("username");
    By passwordField = By.id("pwInput");
    By loginButton = By.id("loginButton");
    By errorAlert = By.className("alert-error");

    // constructor
    public LoginPage(WebDriver driver) {

        this.driver = driver;
        this.wait = new WebDriverWait(driver, Duration.ofSeconds(10));
    }

    // input username
    public void enterUsername(String username) {

        WebElement element =
                wait.until(ExpectedConditions.visibilityOfElementLocated(usernameField));

        element.clear();
        element.sendKeys(username);
    }

    // input password
    public void enterPassword(String password) {

        WebElement element =
                wait.until(ExpectedConditions.visibilityOfElementLocated(passwordField));

        element.clear();
        element.sendKeys(password);
    }

    // klik login
    public void clickLogin() {

        WebElement button =
                wait.until(ExpectedConditions.elementToBeClickable(loginButton));

        button.click();
    }

    // method login
    public void login(String username, String password) {

        enterUsername(username);
        enterPassword(password);
        clickLogin();
    }

    // ambil error message (lebih aman + anti flaky)
    public String getErrorMessage() {

        WebElement error =
                wait.until(ExpectedConditions.visibilityOfElementLocated(errorAlert));

        return error.getText().trim();
    }

    // OPTIONAL (bonus bagus banget)
    public boolean isErrorDisplayed() {

        return wait.until(ExpectedConditions
                .visibilityOfElementLocated(errorAlert))
                .isDisplayed();
    }
}