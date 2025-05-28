# Version v1

⬅️ [Back to Home](../README.md)

➡️ [How to Switch Between Versions](#how-to-switch-between-versions)

---

## Pre-Redesign

We've preserved the previous version of the website (before the major redesign) for historical access or in case it's
needed. It's represented as follows:

* **`archive/OLD-DESIGN-v1` (Branch)**:
* This is a **dedicated branch** that holds the **complete history of the old website design**.
* If minor changes or fixes are ever needed for the old version, they can be made within this branch.

* **`old-design-v1` (Tag)**:
* This is a **permanent tag** that points to the **last commit of the old website version** (at the time it was "
  frozen" before the redesign).
* Tags serve as static "snapshots" of the code's state at a specific point in time. It acts as a reference point for
  the old design.

## How to Switch Between Versions

⬆️ [Back to Top](#version-v1)

⬅️ [Back to Home](../README.md)

---

### Switching to the Old Branch:

```bash
# If you need to work with the code of the old design:
git checkout archive/OLD-DESIGN-v1
```

### Viewing and Checking Out Tags:

```bash
# To see all available tags:
git tag
```

You'll see a list, including `old-design-v1`.

```bash

# To `check out` the state that a tag points to 
# (this will put you in a `detached HEAD` state, which is fine for viewing
git checkout old-design-v1
```

If you want to start development based on this tagged state, you should create a new branch:

```bash
git checkout -b feature/old-v1-TASK old-design-v1
```

Or branch off the `archive/OLD-DESIGN-v1`

```bash
git checkout archive/OLD-DESIGN-v1
```

By adhering to this structure, we ensure a clear separation between active development, current production, and
historical versions of the project.

---

⬆️ [Back to Top](#version-v1)

⬅️ [Back to Home](../README.md)