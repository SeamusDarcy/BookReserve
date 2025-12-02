<?php
session_start();
include 'includes/config.php';

$books = [];
$error = '';

// Load all books from the database including "reserved" status
$sql = "SELECT B.isbn, B.title, B.author, B.Edition, B.Year, B.reserved, C.categoryName
        FROM Books B
        JOIN Category C ON B.categoryId = C.categoryId
        ORDER BY B.title";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    $stmt->close();
} else {
    $error = 'Database error while loading books.';
}

include 'includes/header.php';
include 'includes/nav.php';
?>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background: #1A1C28;
        color: #fff;
    }

    .search-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        flex-grow: 1;
        padding: 20px 0;
    }

    .search-panel {
        background: rgba(255, 255, 255, 0.06);
        padding: 30px 34px;

        max-width: 900px;
        width: 100%;

        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0,0,0,0.25);

        font-size: 20px;
    }

    .search-panel h1 {
        margin: 0 0 18px;
        font-size: 39px;
        font-weight: bold;
        color: #E4E8F2;
    }

    .error-message {
        background-color: #C05C5C;
        color: #fff;
        padding: 10px 14px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 18px;
        text-align: center;
    }

    .results-section {
        margin-top: 10px;
    }

    .results-title {
        font-size: 25px;
        margin-bottom: 12px;
        color: #E4E8F2;
    }

    .results-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 18px;
    }

    .results-table th,
    .results-table td {
        padding: 14px 10px;
        text-align: left;
    }

    .results-table th {
        font-size: 20px;
        border-bottom: 1px solid #2c3145;
        color: #cbd0e0;
    }

    .results-table tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.02);
    }

    .results-table tr:nth-child(odd) {
        background-color: rgba(255, 255, 255, 0.01);
    }

    .no-results {
        margin-top: 10px;
        font-size: 18px;
        color: #9FA6BC;
    }

    .btn-reserve {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 6px;
        border: none;
        background-color: #5568A3;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        transition: 0.2s;
        white-space: nowrap;
    }

    .btn-reserve:hover {
        background-color: #7384C8;
    }

    /* Disabled button style */
    .btn-disabled {
        background-color: #555;
        color: #aaa;
        cursor: not-allowed !important;
    }

    .btn-disabled:hover {
        background-color: #555;
    }

    .reserve-cell {
        text-align: right;
    }
</style>

<div class="search-container">
    <div class="search-panel">
        <h1>All Books</h1>

        <?php if ($error !== ''): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="results-section">
            <div class="results-title">Browse All Books</div>

            <?php if (count($books) > 0): ?>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>Category</th>
                            <th class="reserve-cell">Reserve</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td><?php echo htmlspecialchars($book['Year']); ?></td>
                                <td><?php echo htmlspecialchars($book['categoryName']); ?></td>

                                <td class="reserve-cell">
                                    <?php if ($book['reserved'] == 1): ?>
                                        <span class="btn-reserve btn-disabled">
                                            Unavailable
                                        </span>
                                    <?php else: ?>
                                        <a
                                            class="btn-reserve"
                                            href="reserve.php?isbn=<?php echo urlencode($book['isbn']); ?>"
                                        >
                                            Reserve
                                        </a>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-results">No books found in the database.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
