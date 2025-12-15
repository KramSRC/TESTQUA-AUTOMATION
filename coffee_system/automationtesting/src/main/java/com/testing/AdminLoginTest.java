package com.testing;

import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class AdminLoginTest {

    public static void main(String[] args) {
        
        System.out.println("--- Starting Automation Test ---");

        WebDriverManager.chromedriver().setup();
        WebDriver driver = new ChromeDriver();
        driver.manage().window().maximize();

        try {
            String appUrl = "http://127.0.0.1:8000/login";
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

            driver.get(appUrl);
            System.out.println("Navigated to: " + appUrl);

            wait.until(ExpectedConditions.visibilityOfElementLocated(By.className("coffee-overlay")));

            WebElement emailField = driver.findElement(By.id("email"));
            WebElement passwordField = driver.findElement(By.id("password"));
            WebElement loginBtn = driver.findElement(By.cssSelector(".btn-coffee"));

            emailField.sendKeys("test@admin.com");
            passwordField.sendKeys("12345678");
            
            WebElement rememberMe = driver.findElement(By.id("remember_me"));
            if (!rememberMe.isSelected()) {
                rememberMe.click();
            }

            loginBtn.click();
            System.out.println("✅ Login button clicked successfully.");

            // Pause for 5 seconds so you can see the result before the browser closes
            Thread.sleep(5000);

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
        } finally {
            // 8. Close Browser
            driver.quit();
            System.out.println("--- Test Finished ---");
        }
    }
}