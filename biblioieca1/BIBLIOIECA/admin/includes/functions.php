<?php

define('DATA_DIR', __DIR__ . '/../data/');

if (!file_exists(DATA_DIR)) {
    mkdir(DATA_DIR, 0777, true);
}

function getJsonData($file) {
    $filepath = DATA_DIR . $file;
    if (!file_exists($filepath)) {
        file_put_contents($filepath, json_encode([]));
        return [];
    }
    $content = file_get_contents($filepath);
    return json_decode($content, true) ?? [];
}

function saveJsonData($file, $data) {
    $filepath = DATA_DIR . $file;
    file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
}

function getAllBooks() {
    return getJsonData('books.json');
}

function getBookById($id) {
    $books = getAllBooks();
    foreach ($books as $book) {
        if ($book['id'] === $id) {
            return $book;
        }
    }
    return null;
}

function addBook($book) {
    $books = getAllBooks();
    $books[] = $book;
    saveJsonData('books.json', $books);
}

function updateBook($updated_book) {
    $books = getAllBooks();
    foreach ($books as $key => $book) {
        if ($book['id'] === $updated_book['id']) {
            $books[$key] = $updated_book;
            break;
        }
    }
    saveJsonData('books.json', $books);
}

function deleteBook($id) {
    $books = getAllBooks();
    $books = array_filter($books, function($book) use ($id) {
        return $book['id'] !== $id;
    });
    saveJsonData('books.json', array_values($books));
}

function searchBooks($query) {
    $books = getAllBooks();
    return array_filter($books, function($book) use ($query) {
        return stripos($book['title'], $query) !== false || 
               stripos($book['author'], $query) !== false ||
               stripos($book['isbn'], $query) !== false;
    });
}

function getAvailableBooks() {
    $books = getAllBooks();
    return array_filter($books, function($book) {
        return $book['available'] === true;
    });
}

function getAllUsers() {
    return getJsonData('users.json');
}

function getUserById($id) {
    $users = getAllUsers();
    foreach ($users as $user) {
        if ($user['id'] === $id) {
            return $user;
        }
    }
    return null;
}

function addUser($user) {
    $users = getAllUsers();
    $users[] = $user;
    saveJsonData('users.json', $users);
}

function updateUser($updated_user) {
    $users = getAllUsers();
    foreach ($users as $key => $user) {
        if ($user['id'] === $updated_user['id']) {
            $users[$key] = $updated_user;
            break;
        }
    }
    saveJsonData('users.json', $users);
}

function deleteUser($id) {
    $users = getAllUsers();
    $users = array_filter($users, function($user) use ($id) {
        return $user['id'] !== $id;
    });
    saveJsonData('users.json', array_values($users));
}

function getAllLoans() {
    return getJsonData('loans.json');
}

function getLoanById($id) {
    $loans = getAllLoans();
    foreach ($loans as $loan) {
        if ($loan['id'] === $id) {
            return $loan;
        }
    }
    return null;
}

function addLoan($loan) {
    $loans = getAllLoans();
    $loans[] = $loan;
    saveJsonData('loans.json', $loans);
}

function updateLoan($updated_loan) {
    $loans = getAllLoans();
    foreach ($loans as $key => $loan) {
        if ($loan['id'] === $updated_loan['id']) {
            $loans[$key] = $updated_loan;
            break;
        }
    }
    saveJsonData('loans.json', $loans);
}

function getRecentLoans($limit = 5) {
    $loans = getAllLoans();
    usort($loans, function($a, $b) {
        return strtotime($b['loan_date']) - strtotime($a['loan_date']);
    });
    return array_slice($loans, 0, $limit);
}

function getStatistics() {
    $books = getAllBooks();
    $loans = getAllLoans();
    $users = getAllUsers();
    
    $available_books = array_filter($books, function($book) {
        return $book['available'] === true;
    });
    
    $active_loans = array_filter($loans, function($loan) {
        return $loan['status'] === 'active';
    });
    
    return [
        'total_books' => count($books),
        'available_books' => count($available_books),
        'active_loans' => count($active_loans),
        'total_users' => count($users)
    ];
}

function getCategoryStats() {
    $books = getAllBooks();
    $categories = [];
    
    foreach ($books as $book) {
        $cat = $book['category'];
        if (!isset($categories[$cat])) {
            $categories[$cat] = 0;
        }
        $categories[$cat]++;
    }
    
    return $categories;
}
