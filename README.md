# Learning Website

Learning Website is an AI-powered learning management system for students, teachers, and
administrators. It combines course delivery, assessments, progress tracking, and grounded AI
assistance while keeping teachers in control of all published and graded content.

## Repository layout

```text
apps/
  api/   FastAPI, SQLAlchemy, and Alembic backend
  web/   React, TypeScript, Vite, and Tailwind frontend
```

## Quick start

### Frontend

```powershell
cd apps/web
npm install
npm run dev
```

The web app runs at `http://localhost:5173`.

### Backend

```powershell
cd apps/api
py -3.12 -m venv .venv
.venv\Scripts\Activate.ps1
pip install -e ".[dev]"
fastapi dev app/main.py
```

The API runs at `http://localhost:8000`; interactive documentation is available at `/docs`.
By default, local tests use SQLite. Set `DATABASE_URL` to PostgreSQL for normal development.

### Infrastructure

Copy `.env.example` to `.env`, then run `docker compose up -d` on a machine with Docker. This
starts PostgreSQL with pgvector, Redis, MinIO, and Ollama.

## Current scope

This first slice establishes the branded product shell, responsive student dashboard, API health
checks, environment configuration, and institution-scoped LMS foundation models. Authentication,
course authoring, progress event ingestion, assessments, and AI queues are the next vertical slices.
