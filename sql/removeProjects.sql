DELETE FROM video WHERE project_id >= :projectId;
DELETE FROM picture WHERE project_id >= :projectId;
DELETE FROM gift WHERE project_id >= :projectId;
DELETE FROM projecttag WHERE project_id >= :projectId;
DELETE FROM projectcategory WHERE project_id >= :projectId;
DELETE FROM projectview WHERE project_id >= :projectId;
DELETE FROM transaction WHERE project_id >= :projectId;
DELETE FROM project WHERE id >= :projectId;