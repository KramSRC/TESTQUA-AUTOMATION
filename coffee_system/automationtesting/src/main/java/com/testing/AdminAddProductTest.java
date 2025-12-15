package com.testing;

import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.io.File;
import java.time.Duration;

public class AdminAddProductTest {

    public static void main(String[] args) {
        System.out.println("---  STARTING AUTOMATION TEST ---");

        // 1. Setup Chrome
        WebDriverManager.chromedriver().setup();
        WebDriver driver = new ChromeDriver();
        driver.manage().window().maximize();
        
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(15));

        try {
            
            System.out.println("--- Phase 1: Logging In ---");
            driver.get("http://127.0.0.1:8000/login");

            WebElement email = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("email")));
            email.sendKeys("test@admin.com"); 
            
            WebElement pass = driver.findElement(By.id("password"));
            pass.sendKeys("12345678"); 
            pass.sendKeys(Keys.ENTER); 

            System.out.println("--- Phase 2: Navigating to Add Product ---");
            
            wait.until(ExpectedConditions.urlContains("dashboard"));
            System.out.println(" Dashboard Loaded.");

            WebElement addBtn = wait.until(ExpectedConditions.elementToBeClickable(
                By.xpath("//*[contains(text(),'Add New Coffee')]")
            ));
            addBtn.click();

        
            System.out.println("--- Phase 3: Filling Form ---");
            
            WebElement nameField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.name("name")));
            
            String uniqueName = "Java Automation Coffee " + System.currentTimeMillis();
            nameField.sendKeys(uniqueName);

            
            driver.findElement(By.name("description")).sendKeys("This is an automated test product.");

            driver.findElement(By.name("price")).sendKeys("180.50");

            WebElement categoryElement = driver.findElement(By.name("category_id"));
            Select select = new Select(categoryElement);
            
            try {
                select.selectByIndex(1); 
                System.out.println("Category selected: " + select.getFirstSelectedOption().getText());
            } catch (Exception e) {
                System.out.println(" Could not select category. Is the list empty?");
            }

            String imagePath = "C:\\xampp\\htdocs\\coffee_system\\coffee\\coffee\\public\\images\\1765695170.jpg"; // CHANGE THIS if your file is elsewhere
            File file = new File(imagePath);
            if(file.exists()) {
                driver.findElement(By.name("image")).sendKeys(imagePath);
                System.out.println(" Image uploaded.");
            } else {
                System.out.println(" Image skipped: File not found at " + imagePath);
            }

            System.out.println("--- Phase 4: Submitting ---");

            WebElement saveBtn = driver.findElement(By.cssSelector(".btn-save"));
            
            ((JavascriptExecutor) driver).executeScript("arguments[0].click();", saveBtn);
            
            wait.until(ExpectedConditions.not(ExpectedConditions.urlContains("create")));
            
            System.out.println(" SUCCESS: Form submitted and redirected!");

        } catch (Exception e) {
            System.out.println(" TEST FAILED: " + e.getMessage());
            e.printStackTrace();
        } finally {
             System.out.println(" Waiting 3 seconds before closing...");
            try { Thread.sleep(3000); } catch (InterruptedException e) {}
                
            driver.quit();
            System.out.println("--- Test Finished ---");
        }
    }
}