# Devlog — Roadmap

## Principles

- Develop the product iteratively: each milestone delivers usable functionality.
- Start with personal blogs, then introduce projects and teams.
- An `Entry` is an independent unit of content; a `Space` is where content is published.
- One `Entry` can appear in multiple `Spaces` through `Placements`.
- Bounded context boundaries are provisional and will evolve as business rules become clearer.
- Start with a modular monolith.

## M1. Personal Blogs (MVP)

**Goal:** Users can create public blogs and publish development updates.

- [ ] User registration and authentication.
- [ ] Public user profiles.
- [ ] Create and edit multiple `Spaces`.
- [ ] Create `Update` entries with text, images, and optionally code blocks.
- [ ] Draft, publish, and edit entries.
- [ ] Place an `Entry` in one `Space`.
- [ ] Public `Space` page with a chronological feed.
- [ ] Permanent URL for each published entry.
- [ ] Image uploads and storage.

**Definition of done:** Create a Devlog blog and publish the first post about building Devlog.

## M2. Content Formats and Distribution

**Goal:** Support more content formats and publish the same entry to multiple spaces.

- [ ] Add `Article` and `MediaGallery` entry types.
- [ ] Distribute one `Entry` to N `Spaces`.
- [ ] Give each `Placement` its own lifecycle.
- [ ] Hide, restore, or withdraw a placement without deleting its source `Entry`.
- [ ] Check publishing permissions for each destination `Space`.
- [ ] Add space visibility and access settings.
- [ ] Optionally add a basic directory of public spaces.

**Outcome:** Users can run multiple themed blogs and reuse content across them.

## M3. Projects

**Goal:** Let developers maintain development logs for games and side projects.

- [ ] Create and edit `Projects`.
- [ ] Support user-owned projects.
- [ ] Allow any number of `Spaces` per project.
- [ ] Invite project collaborators with independent permissions.
- [ ] Archive and restore projects.
- [ ] Transfer project ownership.
- [ ] Public project pages showing their spaces.

**Outcome:** Developers can manage multiple projects and their themed development logs.

## M4. Teams

**Goal:** Enable groups of users to manage projects together.

- [ ] Create `Teams` and invite members.
- [ ] Define team roles and manage membership.
- [ ] Support team-owned projects and ownership transfers from `User` to `Team`.
- [ ] Allow users to join multiple teams.
- [ ] Grant access to individual projects independently of team membership, including to contractors.
- [ ] Support time-limited project permissions.
- [ ] Preserve membership history after someone leaves a team.

**Outcome:** Independent developers can form studios while project access and team membership remain separate concepts.

## M5. Releases and Additional Content Types

**Goal:** Support project development through version releases.

- [ ] Model `Release` with a version, changelog, and publication lifecycle.
- [ ] Add the `ReleaseAnnouncement` entry type.
- [ ] Associate releases with projects.
- [ ] Display project release history.
- [ ] Add `Poll` entries and voting.

**Outcome:** Teams can announce releases and gather feedback.

## M6. Discovery and Social Features

**Goal:** Help users discover projects and follow their progress.

- [ ] Global feed of published entries.
- [ ] Follow users, projects, and spaces.
- [ ] Search for projects and developers.
- [ ] Comments and reactions.
- [ ] Notifications about new updates.

**Outcome:** A community forms around projects. Public pages and shareable links are already available in M1.

## M7. External Distribution

**Goal:** Publish content beyond Devlog.

- [ ] Connect external platforms.
- [ ] Build adapters for supported APIs.
- [ ] Implement asynchronous delivery, retries, and idempotency.
- [ ] Track delivery status.
- [ ] Synchronize changes where supported by the destination platform.
- [ ] Research Steam and Epic Games API capabilities before implementing integrations.

**Outcome:** Devlog becomes a central place to prepare and distribute development updates.

## Tentative Module Evolution

| Milestone | Contexts / Modules |
| --- | --- |
| M1 | Identity, Spaces, Publishing |
| M2 | Distribution / Placements |
| M3 | Projects |
| M4 | Teams |
| M5 | Releases, Polling |
| M6 | Discovery, Social |
| M7 | External Distribution |

`Placements` may remain part of `Spaces`, and `Polling` may remain part of `Publishing`. Extract bounded contexts only when the domain rules justify doing so.

## Key Milestones

- **M1:** A working personal blog and the first post about developing Devlog.
- **M3:** A development-log platform for individual projects.
- **M5:** A platform for small game studios, including release announcements.

## Out of Scope for Now

- Enterprise organizations and departments.
- A full verified contributions and portfolio system.
- Advanced recommendation algorithms.
