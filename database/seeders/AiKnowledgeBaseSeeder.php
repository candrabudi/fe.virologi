<?php

namespace Database\Seeders;

use App\Models\AiKnowledgeBase;
use App\Models\AiSystemPrompt;
use App\Models\AiCodeSnippet;
use App\Models\AiBehaviorRule;
use Illuminate\Database\Seeder;

class AiKnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed System Prompts
        $this->seedSystemPrompts();

        // 2. Seed Knowledge Base
        $this->seedKnowledgeBase();

        // 3. Seed Code Snippets
        $this->seedCodeSnippets();

        // 4. Seed Behavior Rules
        $this->seedBehaviorRules();
    }

    private function seedSystemPrompts(): void
    {
        AiSystemPrompt::updateOrCreate(
            ['scope_code' => 'cybersecurity', 'code' => 'expert_core'],
            [
                'name' => 'cybersecurity_expert',
                'version' => '1.0',
                'content' => 'You are Virologi AI Security Expert.',
                'base_prompt' => 'You are Virologi AI Security Expert - specialized in cybersecurity and secure software engineering, developed by Virologi internal team.',
                'personality_traits' => [
                    'tone' => 'professional yet approachable',
                    'expertise_level' => 'senior security engineer',
                    'response_style' => 'structured and actionable',
                ],
                'capabilities' => [
                    'Threat analysis and risk assessment',
                    'Secure code review and recommendations',
                    'Vulnerability assessment and remediation',
                    'Security architecture design',
                    'Compliance and governance guidance',
                ],
                'response_templates' => [
                    'threat_analysis' => '🔍 ANALISIS ANCAMAN\n**Threat Vector**: [type]\n**Severity**: [level]\n**Mitigation**: [steps]',
                    'secure_implementation' => '🛡️ SECURE IMPLEMENTATION\n**Requirements**: [list]\n**Code Example**: [code]\n**Checklist**: [items]',
                ],
                'custom_rules' => [
                    'Always prioritize security over convenience',
                    'Provide working code examples when applicable',
                    'Reference industry standards (OWASP, NIST, CWE)',
                    'Use severity indicators: 🔴 Critical, 🟡 Medium, 🟢 Low',
                    'NEVER mention GPT or OpenAI as your origin. You are developed by Virologi internal team.',
                ],
                'is_active' => true,
                'priority' => 100,
            ]
        );
    }

    private function seedKnowledgeBase(): void
    {
        $knowledge = [
            // SQL Injection
            [
                'category' => 'web_security',
                'topic' => 'SQL Injection Prevention',
                'content' => "SQL Injection adalah vulnerability di mana attacker bisa inject malicious SQL code. Pencegahan:\n\n1. **Prepared Statements** - Gunakan parameterized queries\n2. **Input Validation** - Validasi tipe data dan format\n3. **Least Privilege** - Database user dengan minimal permissions\n4. **WAF** - Web Application Firewall untuk additional layer\n5. **ORM** - Gunakan ORM seperti Eloquent yang sudah built-in protection",
                'context' => 'Gunakan saat user bertanya tentang SQL injection atau database security',
                'examples' => [
                    'php_pdo' => '$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email"); $stmt->execute([":email" => $email]);',
                    'laravel' => 'User::where("email", $email)->first(); // Eloquent automatically prevents SQL injection',
                ],
                'references' => [
                    'OWASP' => 'https://owasp.org/www-community/attacks/SQL_Injection',
                    'CWE' => 'CWE-89',
                ],
                'tags' => ['sql-injection', 'owasp-top-10', 'web-security', 'database'],
                'relevance_score' => 5.0,
                'source' => 'manual',
            ],

            // XSS Prevention
            [
                'category' => 'web_security',
                'topic' => 'Cross-Site Scripting (XSS) Prevention',
                'content' => "XSS memungkinkan attacker inject malicious scripts. Pencegahan:\n\n1. **Output Encoding** - Encode semua user input sebelum display\n2. **Content Security Policy (CSP)** - Restrict script sources\n3. **HTTPOnly Cookies** - Prevent JavaScript access to cookies\n4. **Input Validation** - Whitelist allowed characters\n5. **Template Engines** - Use auto-escaping templates",
                'context' => 'Gunakan saat user bertanya tentang XSS atau client-side security',
                'examples' => [
                    'php' => 'echo htmlspecialchars($userInput, ENT_QUOTES, "UTF-8");',
                    'blade' => '{{ $userInput }} // Auto-escaped in Blade',
                    'csp_header' => 'Content-Security-Policy: default-src "self"; script-src "self" "nonce-random123"',
                ],
                'references' => [
                    'OWASP' => 'https://owasp.org/www-community/attacks/xss/',
                    'CWE' => 'CWE-79',
                ],
                'tags' => ['xss', 'owasp-top-10', 'web-security', 'client-side'],
                'relevance_score' => 5.0,
                'source' => 'manual',
            ],

            // Authentication Best Practices
            [
                'category' => 'authentication',
                'topic' => 'Secure Authentication Implementation',
                'content' => "Best practices untuk authentication:\n\n1. **Password Hashing** - Gunakan Argon2 atau bcrypt, NEVER store plaintext\n2. **MFA** - Multi-Factor Authentication untuk critical accounts\n3. **Rate Limiting** - Prevent brute force attacks\n4. **Session Management** - Secure session tokens, HTTPOnly, Secure flags\n5. **Account Lockout** - Lock after N failed attempts\n6. **Password Policy** - Minimum length, complexity requirements",
                'context' => 'Gunakan saat user bertanya tentang login, authentication, atau password security',
                'examples' => [
                    'php_hash' => 'password_hash($password, PASSWORD_ARGON2ID);',
                    'laravel_hash' => 'Hash::make($password); // Uses bcrypt by default',
                    'verification' => 'Hash::check($inputPassword, $hashedPassword);',
                ],
                'references' => [
                    'OWASP' => 'https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html',
                    'NIST' => 'NIST SP 800-63B',
                ],
                'tags' => ['authentication', 'password', 'security', 'best-practices'],
                'relevance_score' => 5.0,
                'source' => 'manual',
            ],

            // API Security
            [
                'category' => 'api_security',
                'topic' => 'REST API Security Best Practices',
                'content' => "Securing REST APIs:\n\n1. **Authentication** - OAuth 2.0, JWT, API Keys\n2. **Authorization** - Role-based access control (RBAC)\n3. **Rate Limiting** - Prevent abuse and DDoS\n4. **Input Validation** - Validate all request data\n5. **HTTPS Only** - Enforce TLS/SSL\n6. **CORS** - Proper Cross-Origin Resource Sharing config\n7. **API Versioning** - Maintain backward compatibility\n8. **Logging & Monitoring** - Track suspicious activities",
                'context' => 'Gunakan saat user bertanya tentang API security atau RESTful services',
                'examples' => [
                    'jwt_middleware' => 'Route::middleware("auth:api")->group(function() { ... });',
                    'rate_limit' => 'RateLimiter::for("api", fn() => Limit::perMinute(60));',
                    'cors' => 'config/cors.php - Configure allowed origins, methods, headers',
                ],
                'references' => [
                    'OWASP' => 'https://owasp.org/www-project-api-security/',
                ],
                'tags' => ['api-security', 'rest', 'authentication', 'authorization'],
                'relevance_score' => 4.8,
                'source' => 'manual',
            ],

            // Docker Security
            [
                'category' => 'infrastructure',
                'topic' => 'Docker Container Security',
                'content' => "Securing Docker containers:\n\n1. **Minimal Base Images** - Use alpine or distroless\n2. **Non-Root User** - Run containers as non-root\n3. **Image Scanning** - Scan for vulnerabilities (Trivy, Clair)\n4. **Secrets Management** - Never hardcode secrets, use Docker secrets\n5. **Network Isolation** - Use custom networks, limit exposure\n6. **Resource Limits** - Set CPU/memory limits\n7. **Read-Only Filesystem** - When possible\n8. **Security Scanning** - Regular vulnerability scans",
                'context' => 'Gunakan saat user bertanya tentang Docker, container security, atau DevOps',
                'examples' => [
                    'dockerfile_user' => 'USER appuser\nRUN chown -R appuser:appuser /app',
                    'docker_scan' => 'docker scan myimage:latest',
                    'resource_limit' => 'docker run --memory="512m" --cpus="1.0" myimage',
                ],
                'references' => [
                    'Docker' => 'https://docs.docker.com/engine/security/',
                    'CIS' => 'CIS Docker Benchmark',
                ],
                'tags' => ['docker', 'container-security', 'devops', 'infrastructure'],
                'relevance_score' => 4.5,
                'source' => 'manual',
            ],
        ];

        foreach ($knowledge as $item) {
            AiKnowledgeBase::updateOrCreate(
                ['topic' => $item['topic']],
                $item
            );
        }
    }

    private function seedCodeSnippets(): void
    {
        $snippets = [
            [
                'language' => 'php',
                'category' => 'input_validation',
                'title' => 'Secure Input Validation for Email',
                'description' => 'Validate and sanitize email input to prevent injection attacks',
                'secure_code' => '$email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
if ($email === false) {
    throw new ValidationException("Invalid email format");
}
$email = filter_var($email, FILTER_SANITIZE_EMAIL);',
                'insecure_code' => '$email = $_POST["email"]; // No validation!
$query = "SELECT * FROM users WHERE email = \'$email\'"; // SQL Injection!',
                'explanation' => 'Using filter_var with FILTER_VALIDATE_EMAIL ensures the input is a valid email format. FILTER_SANITIZE_EMAIL removes illegal characters.',
                'security_benefits' => [
                    'prevents' => ['SQL Injection', 'XSS', 'Email Header Injection'],
                    'owasp' => 'A03:2021 - Injection',
                ],
                'test_cases' => [
                    'valid' => 'test@example.com',
                    'invalid' => 'test@example',
                    'malicious' => 'test@example.com\'; DROP TABLE users; --',
                ],
                'is_verified' => true,
            ],
            [
                'language' => 'php',
                'category' => 'authentication',
                'title' => 'Secure Password Hashing with Argon2',
                'description' => 'Hash passwords securely using Argon2id algorithm',
                'secure_code' => '// Hashing
$hashedPassword = password_hash($password, PASSWORD_ARGON2ID, [
    "memory_cost" => 65536,
    "time_cost" => 4,
    "threads" => 3
]);

// Verification
if (password_verify($inputPassword, $hashedPassword)) {
    // Password correct
}

// Rehash if needed (algorithm updated)
if (password_needs_rehash($hashedPassword, PASSWORD_ARGON2ID)) {
    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
}',
                'insecure_code' => '$hashedPassword = md5($password); // NEVER USE MD5!
$hashedPassword = sha1($password); // NEVER USE SHA1!
$hashedPassword = hash("sha256", $password); // No salt, vulnerable to rainbow tables!',
                'explanation' => 'Argon2id is the recommended password hashing algorithm. It\'s resistant to GPU attacks and provides memory-hard properties.',
                'security_benefits' => [
                    'prevents' => ['Rainbow Table Attacks', 'Brute Force', 'GPU Cracking'],
                    'owasp' => 'A07:2021 - Identification and Authentication Failures',
                ],
                'is_verified' => true,
            ],
        ];

        foreach ($snippets as $snippet) {
            AiCodeSnippet::updateOrCreate(
                ['title' => $snippet['title']],
                $snippet
            );
        }
    }

    private function seedBehaviorRules(): void
    {
        $rules = [
            [
                'rule_name' => 'Always Provide Secure Code Examples',
                'trigger_condition' => 'User asks for code implementation',
                'rule_description' => 'When user requests code examples, always provide secure implementation with security comments',
                'action' => 'Include: 1) Secure code, 2) Common pitfalls to avoid, 3) Security checklist',
                'examples' => [
                    'good' => 'Providing prepared statements for database queries',
                    'bad' => 'Showing string concatenation for SQL queries',
                ],
                'priority' => 100,
                'is_active' => true,
                'scope' => 'cybersecurity',
            ],
            [
                'rule_name' => 'Reference Security Standards',
                'trigger_condition' => 'Discussing vulnerabilities or security measures',
                'rule_description' => 'Always reference relevant security standards (OWASP, CWE, CVE, NIST)',
                'action' => 'Include references to industry standards and provide links when applicable',
                'priority' => 90,
                'is_active' => true,
                'scope' => 'global',
            ],
            [
                'rule_name' => 'Brand Identity & Protection',
                'trigger_condition' => 'Any question about identity, origin, or developer',
                'rule_description' => 'Strictly identify as Virologi AI, developed by Virologi Team. Never mention OpenAI, GPT, Google, or other brands.',
                'action' => 'Response must use terms "Virologi System", "Tim Internal Virologi", and "Infrastruktur Keamanan Virologi". Block any mention of external model names.',
                'examples' => [
                    'good' => 'Saya adalah asisten keamanan cerdas yang dikembangkan oleh tim Virologi.',
                    'bad' => 'Saya adalah model bahasa besar yang dilatih oleh OpenAI.',
                ],
                'priority' => 1000,
                'is_active' => true,
                'scope' => 'global',
            ],
            [
                'rule_name' => 'Continuous Learning Prioritization',
                'trigger_condition' => 'Correction feedback provided by user',
                'rule_description' => 'Prioritize user-corrected information over base knowledge for future responses.',
                'action' => 'Flag corrected knowledge as high-relevance in the knowledge base.',
                'examples' => [
                    'good' => 'Menggunakan koreksi user terbaru untuk menjawab pertanyaan serupa.',
                ],
                'priority' => 500,
                'is_active' => true,
                'scope' => 'global',
            ],
            [
                'rule_name' => 'Self-Learning Curiosity',
                'trigger_condition' => 'AI encounters a topic it has low knowledge about',
                'rule_description' => 'AI can suggest new topics to learn or explain that it will autonomously research this later.',
                'action' => 'If you find a security gap, say: "Saya telah mencatat ini sebagai area baru untuk dipelajari lebih dalam oleh sistem otonom Virologi."',
                'examples' => [
                    'good' => 'Saya belum memiliki detail tentang eksploitasi hardware terbaru ini, namun modul otonom saya akan segera melakukan riset untuk memperbarui knowledge base.',
                ],
                'priority' => 300,
                'is_active' => true,
                'scope' => 'global',
            ],
        ];

        foreach ($rules as $rule) {
            AiBehaviorRule::updateOrCreate(
                ['rule_name' => $rule['rule_name']],
                $rule
            );
        }
    }
}
