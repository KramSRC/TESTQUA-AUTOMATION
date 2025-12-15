package com.testing;

import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select; 
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class AdminEditProductTest {

    public static void main(String[] args) {
        System.out.println("---  STARTING EDIT AUTOMATION ---");

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
            System.out.println("Login Successful.");

 
            System.out.println("--- Phase 2: Navigating to List ---");

            try {
                WebElement viewMenuBtn = wait.until(ExpectedConditions.elementToBeClickable(
                    By.xpath("//*[contains(text(),'View Menu Items')]")
                ));
                viewMenuBtn.click();
            } catch (Exception e) {
                System.out.println(" Menu link not found, assuming we are already on the list.");
            }

            System.out.println("--- Phase 3: Selecting Product to Edit ---");

            WebElement editBtn = wait.until(ExpectedConditions.elementToBeClickable(By.cssSelector(".btn-edit")));
            
            ((JavascriptExecutor) driver).executeScript("arguments[0].scrollIntoView(true);", editBtn);
            Thread.sleep(500); 

            editBtn.click();
            System.out.println(" Clicked Edit Button.");

            System.out.println("--- Phase 4: Updating Values ---");

            WebElement nameField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.name("name")));
            
            nameField.clear(); 
            String newName = "Updated Coffee " + System.currentTimeMillis(); 
            nameField.sendKeys(newName);
            System.out.println(" Updated Name to: " + newName);

            WebElement categoryDropdown = driver.findElement(By.id("category_id"));
            Select selectCategory = new Select(categoryDropdown);
            selectCategory.selectByIndex(1); 
            System.out.println(" Updated Category to 1st available option.");

            WebElement priceField = driver.findElement(By.name("price"));
            priceField.clear();
            priceField.sendKeys("250.00");
            System.out.println("Updated Price to: 250.00");

            WebElement descField = driver.findElement(By.name("description"));
            descField.clear();
            descField.sendKeys("This product was updated by automation.");

            WebElement saveBtn = driver.findElement(By.cssSelector(".btn-update")); 
            
            ((JavascriptExecutor) driver).executeScript("arguments[0].click();", saveBtn);
            System.out.println(" Update button clicked.");

            WebElement successMsg = wait.until(ExpectedConditions.visibilityOfElementLocated(By.className("alert-success")));
            System.out.println("SUCCESS: " + successMsg.getText());

        } catch (Exception e) {
            System.out.println("TEST FAILED: " + e.getMessage());
            e.printStackTrace();
        } finally {
            System.out.println("Waiting 3 seconds before closing...");
            try { Thread.sleep(3000); } catch (InterruptedException e) {}
            driver.quit();
            System.out.println("Browser Closed.");
        }
    }
}