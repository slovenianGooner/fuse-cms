# Fuse CMS

### Key features

- [ ] Users + role management
- [ ] Permissions
- [ ] Pages (nested set)
- [ ] Posts (various post types)
- [ ] Automatic URL generation (catch-all route)
- [ ] Post/Page versioning
- [ ] Dynamic content creation with blocks
- [ ] Pre-defined templates for pages
- [ ] Asset library

### Task list

- [x] fortify views
- [ ] users + management (CRUD + role assignment)
- [x] roles (defined in code)
- [x] permissions (defined in code)
- [x] role permissions (defined in code)
- [ ] policies
- [ ] pages (nested set)
- [ ] posts (types defined by postType enum)
- [ ] define each admin route by its postType (and according policy)
- [ ] pages can have a postType define which gives us the detail route as well
- [ ] urls are generated after each action in pages/posts
- [ ] a catch-all route catches any url and loads it from the generated urls table
- [ ] post/page versioning
- [ ] block content creation
- [ ] page templates that prefill the blocks in any page...
- [ ] templates are defined in code
- [ ] asset library (uploading + management)
- [ ] image blocks with selection from library
- [ ] more to come
