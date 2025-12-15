package com.testing;

import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class AdminDeleteCoffeeTest {

    public static void main(String[] args) {
        System.out.println("--- 🗑️ STARTING DELETE AUTOMATION ---");

        WebDriverManager.chromedriver().setup();
        WebDriver driver = new ChromeDriver();
        driver.manage().window().maximize();
        
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

        try {

            System.out.println("--- Phase 1: Logging In ---");
            driver.get("http://127.0.0.1:8000/login");

            wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("email")))
                .sendKeys("test@admin.com");
            
            WebElement pass = driver.findElement(By.id("password"));
            pass.sendKeys("12345678");
            pass.sendKeys(Keys.ENTER);

            wait.until(ExpectedConditions.urlContains("dashboard"));
            System.out.println(" Login Successful.");

        
            System.out.println("--- Phase 2: Navigating to Menu List ---");

            try {
                WebElement viewMenuBtn = wait.until(ExpectedConditions.elementToBeClickable(
                    By.xpath("//*[contains(text(),'View Menu Items')]")
                ));
                viewMenuBtn.click();
                System.out.println(" Clicked 'View Menu Items'.");
                
            } catch (TimeoutException e) {
                System.out.println("Could not find 'View Menu Items' link. Assuming we are already on the list.");
            }

            System.out.println("--- Phase 3: Deleting a Coffee ---");

            try {
                WebElement deleteBtn = wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector(".btn-delete")));
                
                ((JavascriptExecutor) driver).executeScript("arguments[0].scrollIntoView(true);", deleteBtn);
                Thread.sleep(500); 

                ((JavascriptExecutor) driver).executeScript("arguments[0].click();", deleteBtn);
                System.out.println(" Clicked Delete button.");

                wait.until(ExpectedConditions.alertIsPresent());
                
                Alert alert = driver.switchTo().alert();
                String alertText = alert.getText();
                System.out.println(" Popup says: " + alertText);
                
                alert.accept(); 
                System.out.println(" Popup Accepted (Clicked OK).");

            } catch (TimeoutException e) {
                System.out.println(" Error: No coffee items found to delete!");
                return; 
            }

            WebElement successMsg = wait.until(ExpectedConditions.visibilityOfElementLocated(By.className("alert-success")));
            
            System.out.println(" SUCCESS MESSAGE: " + successMsg.getText());

        } catch (Exception e) {
            System.out.println(" TEST FAILED: " + e.getMessage());
            e.printStackTrace();
        } finally {
            System.out.println(" Waiting 3 seconds before closing...");
            try { Thread.sleep(3000); } catch (InterruptedException e) {}
            
            driver.quit();
            System.out.println("Browser Closed.");
        }
    }
}