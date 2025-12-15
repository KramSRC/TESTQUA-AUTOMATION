package com.testing;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class UserPlaceOrderTest {

    public static void main(String[] args) {
        
        
        WebDriver driver = new ChromeDriver();
        driver.manage().window().maximize();
        
        String baseUrl = "http://127.0.0.1:8000"; 

        try {
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

            System.out.println("Step 0: Logging in...");
            driver.get(baseUrl + "/login"); 
            driver.findElement(By.name("email")).sendKeys("user@user.com");
            driver.findElement(By.name("password")).sendKeys("12345678");
            driver.findElement(By.tagName("button")).click();
            
            wait.until(ExpectedConditions.urlContains("dashboard"));

            System.out.println("Step 1: Selecting Product...");
            
            WebElement addToCartBtn = wait.until(ExpectedConditions.elementToBeClickable(
                By.cssSelector(".product-card form .btn-primary")
            ));
            
            WebElement qtyInput = driver.findElement(By.cssSelector(".product-card input[name='quantity']"));
            qtyInput.clear();
            qtyInput.sendKeys("2");

            addToCartBtn.click();
            System.out.println(" - Product added to cart.");

            System.out.println("Step 2: Navigating to Cart...");
            
            driver.get(baseUrl + "/cart");

            wait.until(ExpectedConditions.textToBePresentInElementLocated(By.tagName("h2"), "Your Coffee Cart"));

            WebElement checkoutBtn = wait.until(ExpectedConditions.elementToBeClickable(
                By.cssSelector("a.bg-green-600")
            ));
            checkoutBtn.click();
            System.out.println(" - Clicked Checkout button.");

            System.out.println("Step 3: Filling Checkout Details...");

            wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("customer_name")));

            WebElement nameField = driver.findElement(By.id("customer_name"));
            nameField.clear(); 
            nameField.sendKeys("John Doe Automator");

            WebElement phoneField = driver.findElement(By.id("phone_number"));
            phoneField.sendKeys("0917 123 4567");

            WebElement addressField = driver.findElement(By.id("address"));
            addressField.sendKeys("Unit 101, Java Selenium Tower, Code City");

            WebElement notesField = driver.findElement(By.id("notes"));
            notesField.sendKeys("Please make it extra hot!");

            WebElement gcashOption = driver.findElement(By.xpath("//input[@value='gcash']/following-sibling::div[@class='radio-box']"));
            gcashOption.click();
            System.out.println(" - Selected GCash.");

            System.out.println("Step 4: Confirming Order...");

            WebElement confirmBtn = driver.findElement(By.className("btn-confirm"));
            confirmBtn.click();

            System.out.println("SUCCESS: Order placed successfully!");


        } catch (Exception e) {
            System.out.println("ERROR: Test failed.");
            e.printStackTrace();
        } finally {
            try { Thread.sleep(5000); } catch (InterruptedException e) {}
            driver.quit();
        }
    }
}