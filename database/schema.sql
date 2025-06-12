-- Drop tables if they exist (for clean re-seeding)
DROP TABLE IF EXISTS sections;
DROP TABLE IF EXISTS pages;

-- Create 'pages' table
CREATE TABLE pages (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    keywords TEXT,
    h1 VARCHAR(255),
    schema_type VARCHAR(255),
    schema_category VARCHAR(255),
    schema_address JSONB,
    schema_same_as JSONB,
    noindex BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create 'sections' table (также убедитесь, что она есть)
CREATE TABLE sections (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    content JSONB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional: Add indexes for better performance on common lookups
CREATE INDEX idx_pages_name ON pages (name);
CREATE INDEX idx_sections_name ON sections (name);