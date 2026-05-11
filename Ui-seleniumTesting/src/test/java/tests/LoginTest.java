package tests;

import base.BaseTest;
import org.junit.jupiter.api.Test;
import pages.LoginPage;

import static org.junit.jupiter.api.Assertions.assertTrue;

public class LoginTest extends BaseTest {

    // akun valid
    String validUsername = "admin";
    String validPassword = "123456";

   // TC01
    @Test
    public void loginSuccess() throws InterruptedException {

    LoginPage login = new LoginPage(driver);

    login.login(validUsername, validPassword);

    // tunggu redirect selesai
    Thread.sleep(3000);

    assertTrue(driver.getCurrentUrl().contains("dashboard"));
}

    // TC02
    @Test
    public void loginWrongUsername() {

        LoginPage login = new LoginPage(driver);

        login.login("salah", validPassword);
        assertTrue(login.getErrorMessage().length() > 0);
    }

    // TC03
    @Test
    public void loginWrongPassword() {

        LoginPage login = new LoginPage(driver);

        login.login(validUsername, "salah123");

        assertTrue(login.getErrorMessage().length() > 0);
    }

    // TC04
    @Test
    public void loginEmptyUsername() {

        LoginPage login = new LoginPage(driver);

        login.login("", validPassword);

        assertTrue(driver.getCurrentUrl().contains("login"));
    }

    // TC05
    @Test
    public void loginEmptyPassword() {

        LoginPage login = new LoginPage(driver);

        login.login(validUsername, "");

        assertTrue(driver.getCurrentUrl().contains("login"));
    }

    // TC06
    @Test
    public void loginEmptyAll() {

        LoginPage login = new LoginPage(driver);

        login.login("", "");

        assertTrue(driver.getCurrentUrl().contains("login"));
    }

    // TC07
    @Test
    public void loginUsernameWithSpaces() {

        LoginPage login = new LoginPage(driver);

        login.login("   admin ", validPassword);

        assertTrue(driver.getCurrentUrl().contains("login"));
    }

    // TC08
    @Test
    public void loginPasswordWithSpaces() {

        LoginPage login = new LoginPage(driver);

        login.login(validUsername, " 123456 ");

        assertTrue(driver.getCurrentUrl().contains("login"));
    }

    // TC09
    @Test
    public void loginUsernameCaseSensitive() {

        LoginPage login = new LoginPage(driver);

        login.login("Adm!n*", validPassword);

        assertTrue(driver.getCurrentUrl().contains("login"));
    }

    // TC10
    @Test
    public void loginPasswordCaseSensitive() {

        LoginPage login = new LoginPage(driver);

        login.login(validUsername, "123&w5678910");

        assertTrue(driver.getCurrentUrl().contains("login"));
    }
}