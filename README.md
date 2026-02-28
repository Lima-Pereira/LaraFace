# 🛡️ LaraFace - Sistema de Cadastro com Foto

Este projeto é um **CRUD** em Laravel para gestão de pessoas, integrando captura de fotos via Webcam e processamento de imagens para perfil..

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23F7DF1E.svg?style=for-the-badge&logo=javascript&logoColor=black) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

## 🚀 Funcionalidades
- **Cadastro Dinâmico**: Registro de pessoas com nome e foto.
- **Captura via Webcam**: Interface JS para captura de frames de vídeo.
- **Armazenamento Seguro**: Conversão de Base64 para arquivos físicos na pasta `storage`.
- **Exclusão Inteligente**: Ao apagar um registro, o sistema remove também o arquivo de imagem do servidor.

## ⚙️ Como funciona a lógica?
1. **Interface**: O utilizador vê a imagem da webcam e clica em "Tirar Foto".
2. **JavaScript**: O código captura o frame do `<video>`, desenha num `<canvas>` e gera uma string **Base64**.
3. **Laravel**: O `SiteController` recebe esse texto, transforma-o novamente em binário (imagem) e salva o caminho no banco de dados.

## 🛠️ Tecnologias Utilizadas

| Tecnologia | Descrição |
| :--- | :--- |
| ![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white) | Framework PHP para o Backend |
| ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black) | Captura de vídeo e manipulação de Canvas |
| ![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white) | Armazenamento dos dados das pessoas |

## 🛠️ Instalação
1. Clone o repositório: `git clone https://github.com/Lima-Pereira/LaraFace.git`
2. Instale as dependências: `composer install`
3. Crie o link de storage: `php artisan storage:link`
4. Execute as migrations: `php artisan migrate`

---
Desenvolvido por **Henrique Lima** 🚀
