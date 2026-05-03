# PPDB Maffaz - Architecture Overview

## System Architecture

This document outlines the architecture of the Pesantren Student Admissions System (PPDB Maffaz).

### Use Case Diagram

The following diagram illustrates the interactions between different actors and the core functionalities of the system:

```mermaid
usecaseDiagram
    actor "Calon Santri/Wali" as S
    actor "Admin" as A
    actor "Panitia PSB" as P
    actor "Ustadz/Penguji" as U

    package "Sistem PSB Pesantren" {
        usecase "Register & Login" as UC1
        usecase "Isi Formulir & Upload Berkas" as UC2
        usecase "Pembayaran" as UC3
        usecase "Verifikasi Berkas" as UC4
        usecase "Atur Jadwal Tes" as UC5
        usecase "Input Nilai Tes/Wawancara" as UC6
        usecase "Pengumuman Kelulusan" as UC7
    }

    S --> UC1
    S --> UC2
    S --> UC3
    S --> UC7

    A --> UC4
    A --> UC5
    
    P --> UC4
    P --> UC3
    
    U --> UC6
    
    UC6 .> UC7 : <<include>>
    UC4 .> UC2 : <<include>>
```

## Key Actors

- **Calon Santri/Wali** (Prospective Student/Guardian): Registers, fills forms, uploads documents, makes payments, and checks results
- **Admin**: Manages system configuration, user verification, and overall system health
- **Panitia PSB** (Admissions Committee): Verifies documents and processes payments
- **Ustadz/Penguji** (Teachers/Examiners): Records test and interview scores

## Core Use Cases

1. **Register & Login**: User authentication and account creation
2. **Isi Formulir & Upload Berkas**: Application form submission with document uploads
3. **Pembayaran**: Payment processing for registration fees
4. **Verifikasi Berkas**: Document verification by admissions staff
5. **Atur Jadwal Tes**: Schedule management for tests and interviews
6. **Input Nilai Tes/Wawancara**: Score entry by examiners
7. **Pengumuman Kelulusan**: Announcement of admission results

## Technology Stack

- **Frontend**: Blade Templates (69.9%)
- **Backend**: PHP (30%)
- **Framework**: Laravel (implied by Blade usage)

## Dependencies

- Document verification must be completed before announcements
- Test scores must be recorded before results announcement