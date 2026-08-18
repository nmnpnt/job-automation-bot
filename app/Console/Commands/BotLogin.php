<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use App\Models\User;

class BotLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:login {source} {--user=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open a visible browser session for the bot to allow manual login';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $source = strtolower($this->argument('source'));
        $userId = $this->option('user');
        
        $sessionDir = storage_path("app/bot-sessions/{$userId}/{$source}");
        
        $this->info("Opening browser for {$source} (User ID: {$userId})...");
        $this->info("Session Data Directory: {$sessionDir}");
        $this->warn("Please log into {$source} in the opened browser window.");
        $this->warn("Close the browser manually when you are done.");

        // A tiny node script to just open the browser
        $scriptPath = storage_path('app/login.js');
        
        $script = <<<JS
import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';
import fs from 'fs';

puppeteer.use(StealthPlugin());

(async () => {
    const sessionDir = process.argv[2];
    
    if (!fs.existsSync(sessionDir)) {
        fs.mkdirSync(sessionDir, { recursive: true });
    }
    
    console.log('Launching visible browser...');
    const browser = await puppeteer.launch({ 
        headless: false, 
        userDataDir: sessionDir,
        defaultViewport: null
    });
    
    const page = await browser.newPage();
    
    // Attempt to navigate to a generic URL based on source (could be refined)
    await page.goto('https://www.linkedin.com/login').catch(() => {});
    
    console.log('Browser opened. Waiting for you to close it manually...');
    
    // Wait for the browser to be closed by the user
    await new Promise(resolve => {
        browser.on('disconnected', resolve);
    });
    
    console.log('Browser closed. Session saved.');
})();
JS;

        file_put_contents($scriptPath, $script);
        
        $process = new Process(['node', $scriptPath, $sessionDir]);
        $process->setTimeout(null); // No timeout, wait for user
        $process->setTty(Process::isTtySupported());
        
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });
        
        @unlink($scriptPath);
        
        $this->info("Login session closed and saved successfully.");
    }
}
