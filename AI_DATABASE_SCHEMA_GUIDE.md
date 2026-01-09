# 🧠 Virologi AI Database Schema Guide

Dokumen ini berisi daftar tabel yang digunakan oleh sistem **Virologi AI Security Expert** beserta fungsinya masing-masing dalam ekosistem pembelajaran otonom.

---

### 1. ⚙️ Konfigurasi & Identitas
| Nama Tabel | Fungsi |
|:---|:---|
| `ai_settings` | Menyimpan konfigurasi API (OpenAI API Key, Model like GPT-4/5, Timeout, Temperature). |
| `ai_system_prompts` | Menyimpan "jiwa" atau kepribadian AI. Berisi Base Prompt, Personality Traits, dan Aturan Kustom. |

### 2. 📚 Knowledge & Training (Otak AI)
| Nama Tabel | Fungsi |
|:---|:---|
| `ai_knowledge_base` | Database pengetahuan utama (RAG). Tempat menyimpan hasil riset otonom dan data pakar keamanan. |
| `ai_training_data` | Berisi "Gold Standard" (pasangan Q&A ideal) untuk melatih AI merespon dengan sopan, ramah, dan profesional. |
| `ai_behavior_rules` | Daftar aturan perilaku dinamis (Behavioral Guards) yang memandu bagaimana AI harus bersikap dalam situasi tertentu. |
| `ai_code_snippets` | Perpustakaan kode aman (Secure Code) yang bisa direferensikan AI saat membantu coding. |

### 3. 💬 Interaksi & Chat
| Nama Tabel | Fungsi |
|:---|:---|
| `ai_chat_sessions` | Menyimpan sesi obrolan user (Judul sesi, Token, Metadata). |
| `ai_chat_messages` | Riwayat pesan per pesan dalam sebuah sesi (User vs Assistant). |

### 4. 🔄 Learning Loop (Siklus Belajar)
| Nama Tabel | Fungsi |
|:---|:---|
| `ai_learning_sessions` | Mencatat interaksi yang berpotensi menjadi ilmu baru. Menghubungkan Chat dengan proses ekstraksi Knowledge. |
| `ai_feedback` | Menyimpan rating dan koreksi dari user untuk bahan evaluasi AI. |
| `ai_training_data` | (Juga digunakan di sini) Tempat menyimpan hasil Mentorship dari GPT untuk meningkatkan kualitas respon. |

### 5. 📉 Monitoring & Performa
| Nama Tabel | Fungsi |
|:---|:---|
| `ai_usage_logs` | Mencatat penggunaan Token API dan biaya agar pemakaian tetap terkontrol. |
| `ai_performance_metrics` | Mencatat kecepatan respon (Latency) dan tingkat keberhasilan AI dalam menjawab. |

---

### 🚀 Cara Kerja Singkat:
1. **Chat** terjadi via `ai_chat_messages`.
2. **Knowledge** diambil dari `ai_knowledge_base` untuk memperkaya jawaban.
3. **Behavior** dikontrol oleh `ai_behavior_rules`.
4. **Learning** otonom akan memperbarui `ai_knowledge_base` dan `ai_training_data` secara otomatis setiap jam melalui Scheduler.

*Dokumen ini dibuat secara otomatis untuk referensi pengembangan infrastruktur Virologi AI.* 🛡️✨
