<?php if ($result->num_rows > 0): ?>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li class="article-block">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <?php if (!empty($row['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Image de l'article" style="max-width: 100%; height: auto;">
                <?php endif; ?>
                <p><?php echo htmlspecialchars($row['content']); ?></p>
                <p><em>Published on <?php echo $row['created_at']; ?></em></p>

                <?php if (isset($isDashboard) && $isDashboard): ?>
                    <div class="post-actions">
                        <a href="edit_article.php?id=<?php echo $row['id']; ?>" title="Modifier">
                            <i class="fas fa-edit"></i> Modify
                        </a>
                        <a href="delete_article.php?id=<?php echo $row['id']; ?>" title="Supprimer" onclick="return confirmDeletion();">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </div>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No items found</p>
<?php endif; ?>
