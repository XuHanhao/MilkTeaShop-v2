# 奶茶店电商网站

一个基于 Laravel 框架开发的现代化奶茶店电商网站，提供完整的前端购物体验和后端管理功能。

## 功能特性

### 前端功能
- 🔍 商品浏览和搜索
- 🛒 购物车管理
- ❤️ 商品收藏功能
- 📦 订单管理
- 🛍️ 结账流程
- 👤 用户认证系统

### 后台管理
- 📊 数据仪表盘
- 📦 商品管理（增删改查、图片上传）
- 📂 分类管理
- 📋 订单管理
- 📈 订单状态更新

## 技术栈

- **框架**: Laravel
- **语言**: PHP 8.2+
- **数据库**: MySQL
- **前端**: Blade 模板引擎+CSS
- **文件存储**: 本地存储 
## 系统要求

- PHP 8.2 或更高版本
- Composer
- MySQL 或其他数据库

## 安装步骤

1. **克隆项目**

```bash
git clone <项目仓库地址>
cd Tea_lavarel
```

2. **安装依赖**

```bash
composer install
```

3. **配置环境变量**

```bash
cp .env.example .env
```

编辑 `.env` 文件，配置数据库连接和其他环境变量：

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tea_shop
DB_USERNAME=root
DB_PASSWORD=your_password

# 应用密钥（安装时会自动生成）
APP_KEY=
```

4. **生成应用密钥**

```bash
php artisan key:generate
```

5. **运行数据库迁移**

```bash
php artisan migrate
```

6. **创建存储链接**

```bash
php artisan storage:link
```


7. **运行开发服务器**

```bash
php artisan serve
```

应用将在 `http://127.0.0.1:8000` 启动

## 快速设置

使用 composer 脚本快速完成所有安装步骤：

```bash
composer run setup
```


## 项目结构

```
app/
├── Http/Controllers/     # 控制器
│   ├── Admin/            # 后台管理控制器
│   └── Auth/             # 认证控制器
└── Models/               # 数据模型

resources/
├── views/                # Blade 模板
│   ├── admin/            # 后台模板
│   └── auth/             # 认证模板
└── assets/               # 前端资源

routes/
└── web.php               # 路由配置

storage/
└── app/public/           # 公共存储目录
```

## 主要路由

### 前端路由
- `GET /` - 首页
- `GET /products` - 商品列表
- `GET /products/{id}` - 商品详情
- `GET /cart` - 购物车
- `GET /checkout` - 结账页面

### 认证路由
- `GET /login` - 登录页面
- `GET /register` - 注册页面

### 后台路由
- `GET /admin` - 后台仪表盘
- `GET /admin/products` - 商品管理
- `GET /admin/categories` - 分类管理
- `GET /admin/orders` - 订单管理

## 数据库模型

- **Product** - 商品信息
- **Category** - 商品分类
- **Order** - 订单信息
- **OrderItem** - 订单项
- **User** - 用户信息
- **Favorite** - 收藏记录

## 图片上传

系统支持商品图片上传功能：
1. 在后台创建或编辑商品时，点击 "Upload" 按钮
2. 选择图片文件（最大 10MB）
3. 图片自动上传并填充 URL
4. 支持实时预览

## 测试

运行项目测试：

```bash
php artisan test
```

## 贡献

欢迎提交 Issue 和 Pull Request！

## 许可证

MIT License
